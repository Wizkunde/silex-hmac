<?php

namespace Wizkunde\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HmacValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($app, Constraint $constraint)
    {
        // If hmac validation is disabled
        if(isset($app['config']['hmac_validate']) && $app['config']['hmac_validate'] === false) {
            return true;
        }
            // Check if all the headers are set
        if(!$this->checkIfHeadersComplete($app)) {
            return;
        }

        // Check if the request isnt expired yet
        if(!$this->checkIfRequestStillValid($app)) {
            return;
        }

        // Generate hmac hash from path and key
        $hmac = hash_hmac("sha1", $this->buildHmacString($app), $app['config']['hmac_key']);

        // If the hmac's don't match return 403
        if($hmac !== $app['request']->headers->get('hmac')) {
            $this->context->addViolation('Invalid HMAC', array(), $app['request']->headers->get('hmac'));
            return false;
        }

        return true;
    }

    /**
     * Check if the hmac, when and uri headers are set
     *
     * @param $app
     */
    protected function checkIfHeadersComplete($app) {
        // Needs to have the HMAC data
        if(!$app['request']->headers->get('hmac')) {
            $this->context->addViolation('HMAC header not set', array(), $app['request']->headers->get('hmac'));
            return false;
        }

        // Needs to have the WHEN data
        if(!$app['request']->headers->get('when')) {
            $this->context->addViolation('WHEN header not set', array(), $app['request']->headers->get('when'));
            return false;
        }

        // Needs to have the URI data
        if(!$app['request']->headers->get('uri')) {
            $this->context->addViolation('URI  header not set', array(), $app['request']->headers->get('uri'));
            return false;
        }

        return true;
    }

    /**
     * @param $app
     */
    protected function checkIfRequestStillValid($app) {
        if($app['request']->headers->get('when') < strtotime('5 minutes ago')) {
            $this->context->addViolation('HMAC data no longer valid', array(), $app['request']->headers->get('hmac'));
            return false;
        }

        return true;
    }

    protected function buildHmacString($app)
    {
        $hmacData = array(
            $app['request']->getContent(),
            $app['request']->headers->get('uri'),
            $app['request']->headers->get('when')
        );

        return implode($app['config']['hmac_key'], $hmacData);
    }
}

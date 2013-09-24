<?php
namespace Wizkunde\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Wizkunde\Validator\Constraints as HmacAssert;

class HmacValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConstraints()
    {
        $constraint = new Assert\Collection(array(
            'app'   => new HmacAssert\Hmac(),
        ));

        return $constraint;
    }

}
<?php
namespace Wizkunde\Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wizkunde\Traits\ErrorTrait;

/**
 * Class RestControllerProvider
 * @package MJanssen\Provider
 */
class HmacControllerProvider implements ControllerProviderInterface
{
    use ErrorTrait;

    /**
     * @param Application $app
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        // Ensure that all controllers require a valid HMAC key
        $hmacValidation = $this->getHmacMiddleware($app);
        $controllers->before($hmacValidation);

        return $controllers;
    }

    /**
     * Returns hmac middleware for requests
     * @return callable
     */
    private function getHmacMiddleware(Application $app)
    {
        $hmacValidation = function (Request $request, Application $app) {
            $app['service.hmac']->validate(
                array('app' => $app),
                $app['request']->getContent()
            );

            if($app['service.hmac']->hasErrors()) {
                $this->setErrors($app['service.hmac']->getErrors());
                return new JsonResponse(array('errors' => $this->getErrorResponse()));
            }
        };

        return $hmacValidation;
    }
}

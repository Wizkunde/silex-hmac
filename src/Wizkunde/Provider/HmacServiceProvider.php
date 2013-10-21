<?php
namespace Wizkunde\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

use Wizkunde\Service\HmacService;

/**
 * Class ServiceProvider
 * @package Wizkunde\Provider
 */
class HmacServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        /**
         * Add the HMAC validation service
         */
        $app['service.hmac'] = $app->share(function($app) {
                return new HmacService($app['validator'], $app['request']);
        });

        /**
         * Add the middleware to the application
         */
        $app->before(function (Request $request, Application $app) {
            $app['service.hmac']->validate(
                array('app' => $app)
            );

            if($app['service.hmac']->hasErrors()) {
                foreach ($app['service.hmac']->getErrors() as $error) {
                    $errorResponse[] = $error->getPropertyPath().' '.$error->getMessage()."\n";
                }

                return new JsonResponse(array('errors' => $errorResponse));
            }
        });
    }
}
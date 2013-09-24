<?php
namespace Wizkunde\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Wizkunde\Service\HmacService;

/**
 * Class ServiceProvider
 * @package MJanssen\Provider
 */
class HmacServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
    }

    public function connect()
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
    }

    /**
     * Returns hmac middleware for post, put and delete requests
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
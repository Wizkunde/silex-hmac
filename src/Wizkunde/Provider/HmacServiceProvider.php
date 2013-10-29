<?php
namespace Wizkunde\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Wizkunde\Traits\ErrorTrait;
use Wizkunde\Service\HmacService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ServiceProvider
 * @package Wizkunde\Provider
 */
class HmacServiceProvider implements ServiceProviderInterface
{
    use ErrorTrait;

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

        if(isset($app['hmac_validate']) === false || (isset($app['hmac_validate']) && $app['hmac_validate'] === true)) {
            $controllers = $app['controllers'];
            $controllers->before($this->getHmacMiddleware($app));
        }
    }

    /**
     * Get the middleware for hmac validation
     *
     * @param Application $app
     * @return callable
     */
    private function getHmacMiddleware(Application $app)
    {
        return function () use ($app) {
            $app['service.hmac']->validate(
                array('app' => $app),
                $app['request']->getContent()
            );

            if($app['service.hmac']->hasErrors()) {
                $this->setErrors($app['service.hmac']->getErrors());
                return new JsonResponse(array('errors' => $this->getErrorResponse()));
            }
        };
    }
}
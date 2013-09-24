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
}
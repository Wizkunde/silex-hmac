<?php
namespace Wizkunde\Service;

use Silex\Application;
use Silex\Provider\ValidatorServiceProvider;
use Wizkunde\Provider\HmacServiceProvider;
use Wizkunde\Service\HmacService;

class HmacServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test extract single entity
     */
    public function testHmacService()
    {
        $app = $this->getMockApplication();

        $hmacValidator = new HmacService($app['validator'], $app['request']);

        $this->assertTrue($hmacValidator->validate($app));
    }

    /**
     * Get a default silex application
     * @return Application
     */
    protected function getMockApplication()
    {
        $app = new Application();

        $app->register(
            new ValidatorServiceProvider()
        );

        $app->register(
            new HmacServiceProvider()
        );

        return $app;
    }
}
<?php
namespace Wizkunde\Provider;

use Silex\Application;
use Silex\Provider\ValidatorServiceProvider;
use Wizkunde\Provider\HmacServiceProvider;

class ServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if services are registered
     */
    public function testIfServicesAreRegistered()
    {
        $app = $this->getMockApplication();
        $this->assertTrue(isset($app['validator']));
        $this->assertTrue(isset($app['service.hmac']));

        // Test for a invalid one so that we know this test will fail if something under the hood is wrong
        $this->assertFalse(isset($app['foo']));
    }

    /**
     * Test if resolver service can be instantiated
     */
    public function testHmacService()
    {
        $app = $this->getMockApplication();

        $this->assertInstanceOf('Wizkunde\Service\HmacService', $app['service.hmac']);
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
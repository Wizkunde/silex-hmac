<?php

namespace Wizkunde\Provider;

use Wizkunde\Traits\SilexMock;

class ServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    // Implement mock application of silex
    use SilexMock;

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
}
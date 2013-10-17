<?php
namespace Wizkunde\Service;

use Wizkunde\Traits\SilexMock;

class HmacServiceTest extends \PHPUnit_Framework_TestCase
{
    // Implement the mocking interface for a silex application
    use SilexMock;

    /**
     * Test extract single entity
     */
    public function testHmacService()
    {
        $app = $this->getMockApplication();

        $this->assertTrue($app['service.hmac']->validate(array('app' => $app)));
    }
}
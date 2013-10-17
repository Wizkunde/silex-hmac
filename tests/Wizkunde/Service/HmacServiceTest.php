<?php
namespace Wizkunde\Service;

use Wizkunde\Traits\SilexMock;

class HmacServiceTest extends \PHPUnit_Framework_TestCase
{
    // Implement the mocking interface for a silex applicationx
    use SilexMock;

    /**
     * Test extract single entity
     */
    public function testHmacServiceFailsIfNoHeadersAreSet()
    {
        $app = $this->getMockApplication();

        $app['service.hmac']->validate(array('app' => $app));

        $this->assertTrue($app['service.hmac']->hasErrors());
    }

    /**
     * Test extract single entity
     */
    public function testHmacServiceFailsIfHeadersHaveWrongValues()
    {
        $app = $this->getMockApplication();

        $app['request']->headers->set['hmac'] = sha1('testheader');
        $app['request']->headers->set['when'] = time();
        $app['request']->headers->set['uri'] = '/';

        $app['service.hmac']->validate(array('app' => $app));

        $this->assertTrue($app['service.hmac']->hasErrors());
    }

    /**
     * Test extract single entity
     */
    public function testHmacServiceSucceedsIfHeadersHaveProperValues()
    {
        $app = $this->getMockApplication();
        $this->setMockValidator($app);

        $app['request']->headers->set['hmac'] = sha1('testheader');
        $app['request']->headers->set['when'] = time();
        $app['request']->headers->set['uri'] = '/';

        $app['service.hmac']->validate(array('app' => $app));

        $this->assertFalse($app['service.hmac']->hasErrors());
    }
}
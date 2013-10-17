<?php

namespace Wizkunde\Traits;

use Silex\Application;
use Silex\Provider\ValidatorServiceProvider;
use Wizkunde\Provider\HmacServiceProvider;
use Wizkunde\Service\HmacService;

trait SilexMock
{
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

        $app['service.hmac'] = new HmacService($app['validator'], $this->getMockRequest());

        return $app;
    }

    /**
     * Mock the request
     *
     * @return mixed
     */
    protected function getMockRequest()
    {
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request', array('getContent'));
        $request->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue(json_encode(array('id' => 1, 'name' => 'foobaz'))));

        return $request;
    }
}
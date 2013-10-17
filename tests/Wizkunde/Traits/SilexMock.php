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
        $app['request'] = $this->getMockRequest();

        return $app;
    }

    protected function setMockValidator($app)
    {
        $hmacService = $this->getMock('Wizkunde\Service\HmacService', array('validate'), array($app['validator'], $app['request']));
        $hmacService->expects($this->any())
            ->method('validate')
            ->will($this->returnValue(true));

        $app['service.hmac'] = $hmacService;
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
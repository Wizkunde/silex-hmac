<?php

namespace Wizkunde\Dispatcher\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Wizkunde\Traits\ErrorTrait;

class HmacMiddleware implements MiddlewareInterface
{
    use ErrorTrait;

    protected $request = null;
    protected $app = null;

    public function __construct(Request $request, Application $app)
    {
        $this->request = $request;
        $this->app = $app;
    }

    public function getMiddleware()
    {
        return function (Request $request, Application $app) {
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

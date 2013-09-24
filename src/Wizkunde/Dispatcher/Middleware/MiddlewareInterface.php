<?php

namespace Wizkunde\Dispatcher\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

interface MiddlewareInterface
{
    public function __construct(Request $request, Application $app);
}
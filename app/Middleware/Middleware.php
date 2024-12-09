<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Middleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    abstract public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface;
}

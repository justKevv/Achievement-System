<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

class RoleMiddleware extends Middleware
{
    private $role;

    public function __construct($container, $role)
    {
        parent::__construct($container);
        $this->role = $role;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== $this->role) {
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        return $handler->handle($request);
    }
}

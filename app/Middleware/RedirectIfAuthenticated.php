<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

class RedirectIfAuthenticated extends Middleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
            $response = new \Slim\Psr7\Response();
            return $response->withHeader('Location', '/dashboard')->withStatus(302);
        }

        return $handler->handle($request);
    }
}

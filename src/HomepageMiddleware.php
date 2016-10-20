<?php
namespace MyApp;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Relay\MiddlewareInterface;

class HomepageMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param callable|null $next
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $username = $request->getAttribute('Psr7Middlewares\Middleware')["USERNAME"];
        $response->getBody()->write("hello world");

        return $next($request, $response);
    }

}
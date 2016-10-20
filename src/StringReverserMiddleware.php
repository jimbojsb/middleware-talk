<?php
namespace MyApp;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseInterface;
use Relay\MiddlewareInterface;
use Zend\Diactoros\Stream;

class StringReverserMiddleware implements MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        /** @var ResponseInterface $response */
        $response = $next($request, $response);
        $string = $response->getBody()->__toString();
        $reversed = strrev($string);

        $stream = new Stream("php://memory", 'w');
        $stream->write($reversed);

        $response = $response->withBody($stream);
        return $response;
    }

}
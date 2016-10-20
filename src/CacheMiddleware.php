<?php
namespace MyApp;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Relay\MiddlewareInterface;

class CacheMiddleware implements MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $cacheFilename = __DIR__ . '/../cache/' . md5($request->getUri()->__toString());
        if (file_exists($cacheFilename)) {
            $responseBody = file_get_contents($cacheFilename);
            $response->getBody()->write($responseBody);
            return $response;
        }

        /** @var RequestInterface $response */
        $response = $next($request, $response);
        $bytes = $response->getBody()->__toString();
        file_put_contents($cacheFilename, $bytes);
        return $next($request, $response);
    }
}
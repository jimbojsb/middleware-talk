<?php
require_once __DIR__ . '/../vendor/autoload.php';

$middlewares = [];
$middlewares[] = new \Psr7Middlewares\Middleware\BasicAuthentication(["admin" => "password"]);
$middlewares[] = new \MyApp\CacheMiddleware();
$middlewares[] = new \MyApp\HomepageMiddleware();


$relay = (new \Relay\RelayBuilder())->newInstance($middlewares);

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

$response = $relay($request, new \Zend\Diactoros\Response());

$sapiEmitter = new \Zend\Diactoros\Response\SapiEmitter();
$sapiEmitter->emit($response);
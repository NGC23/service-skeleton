<?php

declare(strict_types=1);

require 'vendor/autoload.php';
require 'config/container.php';

use League\Route\Router;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Laminas\Diactoros\ServerRequestFactory;

$http = new Swoole\Http\Server('0.0.0.0', 9501);

Swoole\Runtime::enableCoroutine();

$responseFactory = new \Laminas\Diactoros\ResponseFactory();

$strategy = new League\Route\Strategy\JsonStrategy($responseFactory);
$strategy->setContainer($container);

/** @var Router $router */
$router   = (new League\Route\Router)->setStrategy($strategy);

$http->on('Request', function (Request $request, Response $response) use ($router) {
    //convert the request to psr7 request
    $request = ServerRequestFactory::fromGlobals(
        $request->server, $request->get, $request->post, $request->cookie, $request->files
    );

    //Routing
    $router->map('GET', '/blah', 'Neil\Test\Application\Controller::get');

    //dispatch the response that it is returned in the response interface
    $result = $router->dispatch($request);

    $response->header('Content-Type', 'application/json;');
    $response->end((string) $result->getBody());
});

$http->start();
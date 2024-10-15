<?php

declare (strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use DI\Container;
use Slim\Handlers\Strategies\RequestResponseArgs;
use App\Middleware\AddJsonResponseHeader;
use App\Controllers\ProductIndex;
use App\Controllers\Products;
use App\Middleware\GetProduct;
use Slim\Routing\RouteCollectorProxy;

require dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container;

AppFactory::setContainer($container);

$app = AppFactory::create();

$collector = $app->getRouteCollector();

$collector->setDefaultInvocationStrategy(new RequestResponseArgs);

$app->addBodyParsingMiddleware();

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();

$error_handler->forceContentType('application/json');

$app->add(new AddJsonResponseHeader);


$app->get('/api/products/{id:[0-9]+}', App\Controllers\Products::class . ':show')->add(App\Middleware\GetProduct::class);

$app->get('/api/products', ProductIndex::class);

$app->post('/api/products', [App\Controllers\Products::class, 'create']);

$app->patch('/api/products/{id:[0-9]+}', Products::class. ':update')->add(App\Middleware\GetProduct::class);

$app->delete('/api/products/{id:[0-9]+}', Products::class. ':delete')->add(App\Middleware\GetProduct::class);

$app->run();
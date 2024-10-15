<?php

declare (strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use DI\Container;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/api/products', function (Request $request, Response $response) {

    // $body = json_encode([1 => "One", 2 => "Two"]);

    // $response->getBody()->write($body);

    //require dirname(__DIR__) . '/src/App/Database.php';
    //require dirname(__DIR__) . '/src/App/Repositories\ProductRepository.php';


    $database = new App\Database;

    $repository = new App\Repositories\ProductRepository($database);

    $data = $repository->getAll();

    $body = json_encode($data);

    $response->getBody()->write($body);
    // $pdo = $database->getConnection();

    // if($pdo) {
    //     echo "connected";
    // }

    // $stmt = $pdo->query('SELECT * FROM product');

    // $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

//Routes

$app->get('/', function(Request $request, Response $response){
    $response_array = [
        'message' => 'Welcome to our API'
    ];
    $response_str = json_encode($response_array);
    $response->getBody()->write($response_str);
    return $response;
});

$app->run();
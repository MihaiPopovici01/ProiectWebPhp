<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Home
$app->get('/', function(Request $request, Response $response){
    $response_array = [
        'message' => 'Welcome to our API'
    ];
    $response_str = json_encode($response_array);
    $response->getBody()->write($response_str);
    return $response;
});
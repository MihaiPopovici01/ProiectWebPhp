<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../middlewares/jsonBodyParser.php';

//Home
$app->get('/', function(Request $request, Response $response){
    $response_array = [
        'message' => 'Welcome to our API'
    ];
    $response_str = json_encode($response_array);
    $response->getBody()->write($response_str);
    return $response;
});

//Get all disciplines
$app->get('/disciplines', function(Request $request, Response $response){
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->select('Id', 'Name', 'Prof_Name', 'Room', 'Cours_Start_Hour', 'Year', 'Semester')
        ->from('Disciplines')
    ;

    $results = $queryBuilder->executeQuery()->fetchAll();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
});

//Get disciplin from id
$app->get('/disciplines/{id}', function(Request $request, Response $response, array $args){
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->select('Id', 'Name', 'Prof_Name', 'Room', 'Cours_Start_Hour', 'Year', 'Semester')
        ->from('Disciplines')
        ->where('Id = ?')
        ->setParameter(1, $args['id'])
    ;

    $results = $queryBuilder->executeQuery()->fetchAssociative();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
});


//Add a discipline
$app->post('/disciplines/add' , function(Request $request, Response $response){
    
    $parsedBody = $request->getParsedBody();
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->insert('Disciplines')
        ->setValue('Name', '?')
        ->setValue('Prof_Name', '?')
        ->setValue('Room', '?')
        ->setValue('Cours_Start_Hour', '?')
        ->setValue('Year', '?')
        ->setValue('Semester', '?')
        ->setParameter(1, $parsedBody['Name'])
        ->setParameter(2, $parsedBody['Prof_Name'])
        ->setParameter(3, $parsedBody['Room'])
        ->setParameter(4, $parsedBody['Cours_Start_Hour'])
        ->setParameter(5, $parsedBody['Year'])
        ->setParameter(6, $parsedBody['Semester'])
    ;

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

})->add($jsonBodyParser);

//Update a discipline
$app->put('/disciplines/{id}' , function(Request $request, Response $response, array $args){
    
    $parsedBody = $request->getParsedBody();
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
    ->update('Disciplines')
    ->set('Name', '?')
    ->set('Prof_Name', '?')
    ->set('Room', '?')
    ->set('Cours_Start_Hour', '?')
    ->set('Year', '?')
    ->set('Semester', '?')
    ->where('Id = ?')
    ->setParameter(1, $parsedBody['Name'])
    ->setParameter(2, $parsedBody['Prof_Name'])
    ->setParameter(3, $parsedBody['Room'])
    ->setParameter(4, $parsedBody['Cours_Start_Hour'])
    ->setParameter(5, $parsedBody['Year'])
    ->setParameter(6, $parsedBody['Semester'])
    ->setParameter(7, $args['id'])
;
    

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

})->add($jsonBodyParser);

//Delete a discipline

$app->delete('/disciplines/{id}' , function(Request $request, Response $response, array $args){
    
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
    ->delete('Disciplines')
    ->where('Id = ?')
    ->setParameter(1, $args['id'])
    ;
    

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

});
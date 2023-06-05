<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


//Get all events
$app->get('/events', function(Request $request, Response $response){
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->select('Id', 'Name', 'Start_Date', 'End_Date', 'Description', 'Students_IDs')
        ->from('Events')
    ;

    $results = $queryBuilder->executeQuery()->fetchAll();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
});


//Get event from id
$app->get('/events/{id}', function(Request $request, Response $response, array $args){
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->select('Id', 'Name', 'Start_Date', 'End_Date', 'Description', 'Students_IDs')
        ->from('Events')
        ->where('Id = ?')
        ->setParameter(1, $args['id'])
    ;

    $results = $queryBuilder->executeQuery()->fetchAssociative();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
});

//Create a new event
$app->post('/events/add' , function(Request $request, Response $response){
    
    $parsedBody = $request->getParsedBody();
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->insert('Events')
        ->setValue('Name', '?')
        ->setValue('Start_Date', '?')
        ->setValue('End_Date', '?')
        ->setValue('Description', '?')
        ->setValue('Students_IDs', '?')
        ->setParameter(1, $parsedBody['Name'])
        ->setParameter(2, $parsedBody['Start_Date'])
        ->setParameter(3, $parsedBody['End_Date'])
        ->setParameter(4, $parsedBody['Description'])
        ->setParameter(5, $parsedBody['Students_IDs'])
    ;

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

})->add($jsonBodyParser);

//Update an event
$app->put('/events/{id}' , function(Request $request, Response $response, array $args){
    
    $parsedBody = $request->getParsedBody();
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
    ->update('Events')
    ->set('Name', '?')
    ->set('Start_Date', '?')
    ->set('End_Date', '?')
    ->set('Description', '?')
    ->set('Students_IDs', '?')
    ->where('Id = ?')
    ->setParameter(1, $parsedBody['Name'])
    ->setParameter(2, $parsedBody['Start_Date'])
    ->setParameter(3, $parsedBody['End_Date'])
    ->setParameter(4, $parsedBody['Description'])
    ->setParameter(5, $parsedBody['Students_IDs'])
    ->setParameter(6, $args['id'])
;
    

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

})->add($jsonBodyParser);

//Delete an event
$app->delete('/events/{id}' , function(Request $request, Response $response, array $args){
    
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
    ->delete('Events')
    ->where('Id = ?')
    ->setParameter(1, $args['id'])
    ;
    

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

});
<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


//Get all study groups
$app->get('/study_groups', function(Request $request, Response $response){
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->select('Id', 'Disciplin', 'Meet_datetime', 'Students_IDs')
        ->from('Study_groups')
    ;

    $results = $queryBuilder->executeQuery()->fetchAll();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
});


//Get study group from id
$app->get('/study_groups/{id}', function(Request $request, Response $response, array $args){
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->select('Id', 'Disciplin', 'Meet_datetime', 'Students_IDs')
        ->from('Study_groups')
        ->where('Id = ?')
        ->setParameter(1, $args['id'])
    ;

    $results = $queryBuilder->executeQuery()->fetchAssociative();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
});

//Create a new study group
$app->post('/study_groups/add' , function(Request $request, Response $response){
    
    $parsedBody = $request->getParsedBody();
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->insert('Study_groups')
        ->setValue('Disciplin', '?')
        ->setValue('Meet_datetime', '?')
        ->setValue('Students_IDs', '?')
        ->setParameter(1, $parsedBody['Disciplin'])
        ->setParameter(2, $parsedBody['Meet_datetime'])
        ->setParameter(3, $parsedBody['Students_IDs'])
    ;

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

})->add($jsonBodyParser);

//Update a study group
$app->put('/study_groups/{id}' , function(Request $request, Response $response, array $args){
    
    $parsedBody = $request->getParsedBody();
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
    ->update('Study_groups')
    ->set('Disciplin', '?')
    ->set('Meet_datetime', '?')
    ->set('Students_IDs', '?')
    ->where('Id = ?')
    ->setParameter(1, $parsedBody['Name'])
    ->setParameter(2, $parsedBody['Meet_datetime'])
    ->setParameter(3, $parsedBody['Students_IDs'])
    ->setParameter(4, $args['id'])
;
    

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

})->add($jsonBodyParser);

//Delete a study group
$app->delete('/study_groups/{id}' , function(Request $request, Response $response, array $args){
    
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
    ->delete('Study_groups')
    ->where('Id = ?')
    ->setParameter(1, $args['id'])
    ;
    

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

});
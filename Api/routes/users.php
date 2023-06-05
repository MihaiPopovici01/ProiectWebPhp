<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../middlewares/jsonBodyParser.php';

//Get all users
$app->get('/users', function(Request $request, Response $response){
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->select('Id', 'Name', 'Email', 'Password', 'Year', 'Semester', 'Is_admin')
        ->from('Users')
    ;

    $results = $queryBuilder->executeQuery()->fetchAll();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
});

//Register a user
$app->post('/register' , function(Request $request, Response $response){
    
    $parsedBody = $request->getParsedBody();
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->insert('Users')
        ->setValue('Name', '?')
        ->setValue('Email', '?')
        ->setValue('Password', '?')
        ->setValue('Year', '?')
        ->setValue('Semester', '?')
        ->setParameter(1, $parsedBody['Name'])
        ->setParameter(2, $parsedBody['Email'])
        ->setParameter(3, password_hash($parsedBody['Password'], PASSWORD_DEFAULT))
        ->setParameter(5, $parsedBody['Year'])
        ->setParameter(6, $parsedBody['Semester'])
    ;

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

})->add($jsonBodyParser);

//Get user from id
$app->get('/users/{id}', function(Request $request, Response $response, array $args){
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->select('Id', 'Name', 'Email', 'Password', 'Year', 'Semester', 'Is_admin')
        ->from('Users')
        ->where('Id = ?')
        ->setParameter(1, $args['id'])
    ;

    $results = $queryBuilder->executeQuery()->fetchAssociative();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
});

//Get users from year x
$app->get('/users/year/{x}', function(Request $request, Response $response, array $args){
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
        ->select('Id', 'Name', 'Email', 'Password', 'Year', 'Semester', 'Is_admin')
        ->from('Users')
        ->where('Year = ?')
        ->setParameter(1, $args['x'])
    ;

    $results = $queryBuilder->executeQuery()->fetchAll();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');
});

//Update a user
$app->put('/users/{id}' , function(Request $request, Response $response, array $args){
    
    $parsedBody = $request->getParsedBody();
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
    ->update('Users')
    ->set('Name', '?')
    ->set('Email', '?')
    ->set('Password', '?')
    ->set('Year', '?')
    ->set('Semester', '?')
    ->set('Is_admin', '?')
    ->where('Id = ?')
    ->setParameter(1, $parsedBody['Name'])
    ->setParameter(2, $parsedBody['Email'])
    ->setParameter(3, $parsedBody['Password'])
    ->setParameter(4, $parsedBody['Year'])
    ->setParameter(5, $parsedBody['Semester'])
    ->setParameter(6, $parsedBody['Is_admin'])
    ->setParameter(7, $args['id'])
;
    

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

})->add($jsonBodyParser);

//Delete a user

$app->delete('/users/{id}' , function(Request $request, Response $response, array $args){
    
    $queryBuilder = $this->get('DB')->getQueryBuilder();

    $queryBuilder
    ->delete('Users')
    ->where('Id = ?')
    ->setParameter(1, $args['id'])
    ;
    

    $results = $queryBuilder->executeStatement();
    $response->getBody()->write(json_encode($results));
    return $response->withHeader('Content-Type', 'application/json');

});
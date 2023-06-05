<?php


use DI\Container;
use DI\ContainerBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../src/definitions.php');
$container = $containerBuilder->build();

AppFactory::setContainer($container);

$app = AppFactory::create();

//Routes
require_once __DIR__ . '/../routes/disciplines.php';
require_once __DIR__ . '/../routes/users.php';
require_once __DIR__ . '/../routes/events.php';
require_once __DIR__ . '/../routes/study_groups.php';

$app->run();
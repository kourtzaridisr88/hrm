<?php

use Narrowspark\HttpEmitter\SapiEmitter;
use Hr\Infrastructure\Database\Database;
use Laminas\Diactoros\ServerRequestFactory;
use Hr\Infrastructure\Foundation\Router;
use DI\Container;

$builder = new \DI\ContainerBuilder();

$builder->addDefinitions(__DIR__ . '/definitions.php');

$app = $builder->build();

$jsonData = (array) json_decode(file_get_contents('php://input')) ?? [];

$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    array_merge($jsonData, $_POST),
    $_COOKIE,
    $_FILES
);

$app->set('emitter', new SapiEmitter());
$app->set('router', new Router());
$app->set('request', $request);
$app->set('db', Database::instance());

return $app;
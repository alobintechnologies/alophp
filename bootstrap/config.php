<?php

use League\Container\Container;
/**
 * Declaring the service providers available in this application
 */
$serviceProviders = [
  'app' => 'AppServiceProvider'
  'dotEnv' => 'DotEnvServiceProvider',
  'debugError' => 'PrettyErrorServiceProvider',
  'errorHandler' => 'BugSnagServiceProvider'
];

// Register each service provider
foreach ($serviceProviders as $service => $serviceClass) {
  $serviceClass->register();
}


/**
 * Container setup
 */
$container = new Container();
$container->add('PDO')
    ->withArgument(getenv('DB_CONN'))
    ->withArgument(getenv('DB_USER'))
    ->withArgument(getenv('DB_PASS'));

$container->add('Twig_Environment')
    ->withArgument(new Twig_Loader_Filesystem(__DIR__ . '/../views/'));

/**
 * Routes
 */
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $routes = require __DIR__ . '/routes.php';
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
});

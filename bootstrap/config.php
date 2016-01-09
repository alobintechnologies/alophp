<?php

require __DIR__ . '/paths.php';

use League\Container\Container;

/**
 * Container setup
 */
$container = new Container();

/**
 * Declaring the service providers available in this application
 */
$serviceProviders = require __DIR__ . '/providers.php';

// Register each service provider
foreach ($serviceProviders as $service => $serviceClass) {
  $serviceObj = new $serviceClass;
  $serviceObj->register($container);
}



/**
 * Routes
 */
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $routes = require __DIR__ . '/routes.php';
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
});

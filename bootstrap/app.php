<?php
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__.'/config.php';


/**
 * Dispatch
 */
$request = Request::createFromGlobals();
$route_info = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
switch ($route_info[0]) {
    case Dispatcher::NOT_FOUND:
        Response::create("404 Not Found", Response::HTTP_NOT_FOUND)->send();
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        Response::create("405 Method Not Allowed", Response::HTTP_METHOD_NOT_ALLOWED)->send();
        break;
    case Dispatcher::FOUND:
        $class_name = $route_info[1][0];
        $method = $route_info[1][1];
        $vars = $route_info[2];
        $object = $container->get($class_name);

        $response = $object->$method($vars);
        if ($response instanceof Response) {
            $response->prepare(Request::createFromGlobals());
            $response->send();
        }
        break;
}

<?php

namespace Hr\Infrastructure\Foundation;

use function FastRoute\simpleDispatcher;
use FastRoute\RouteCollector;

class Router
{
    /**
     * The inversion of control instance
     * 
     * @var \FastRoute\Dispatcher
     */
    public $dispatcher;

    /**
     * Collect application api routes
     * 
     * @return void
     */
    public function collect()
    {
        $this->dispatcher = simpleDispatcher(function(RouteCollector $router) {
            include_once __DIR__ . '/../../../routes/api.php';
        });
    }

    /**
     * Dispatch a request to controller
     * 
     * @param \DI\Container $application
     * @param string $method The request method from $_SERVER
     * @param string $uri The incoming request's uri
     * @return \Laminas\Diactoros\ResponseInterface
     */
    public function dispatch($application, $method, $uri)
    {
        $routeInfo = $this->dispatcher->dispatch($method, $uri);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                return Response::error([], 'Endpoint Not Found!', 404);
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                return Response::error([], 'Method Not Allowed!', 405);
            case \FastRoute\Dispatcher::FOUND:
                $controller = $routeInfo[1];
                $parameters = $routeInfo[2];

                return $application->call($controller, $parameters);
        }
    }
}
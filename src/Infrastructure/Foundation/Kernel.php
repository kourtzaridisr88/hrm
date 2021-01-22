<?php

namespace Hr\Infrastructure\Foundation;

use Laminas\Diactoros\ServerRequest;
use DI\Container;
use Hr\Infrastructure\Exceptions\ValidationException;

class Kernel 
{
    /**
     * The inversion of control instance
     * 
     * @var \DI\Container
     */
    public $application;

    /**
     * The router instance
     * 
     * @var Router
     */
    public $router;

    /**
     * Create's a new Kernel instance.
     *
     * @param \DI\Container $application
     * @param \Hr\Infrastructure\Foundation\Router
     */
    public function __construct(Container $application, Router $router)
    {
        $this->application = $application;
        $this->router = $router;
    }

    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Laminas\Diactoros\ServerRequest  $request
     * @return \Laminas\Diactoros\ResponseInterface
     */
    public function handle(ServerRequest $request)
    {
        $this->application->get('router')->collect();

        return $this->sendRequestThroughRouter($request);
    }

    /**
     * Dispatch a request to router.
     * 
     * @param $request \Laminas\Diactoros\ServerRequest
     * @return \Laminas\Diactoros\ResponseInterface
     */
    public function sendRequestThroughRouter($request)
    {
        $router = $this->application->get('router');
        try {
            $response = $router->dispatch(
                $this->application, 
                $_SERVER['REQUEST_METHOD'], 
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            );
        } catch(\Exception $e) {
            if ($e instanceof ValidationException) {
                $response = Response::error($e->errors, $e->getMessage(), $e->code);
            } else {
                $response = Response::error([], $e->getMessage(), 500);
            }
        }

        return $response;
    }

    /**
     * Call the terminate method on everything that needs to shutdown.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($response)
    {
        $this->application->get('db')->terminate();
        
        $this->application->make('emitter')->emit($response);
    }
}   
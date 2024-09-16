<?php

namespace Core;

class Router
{
    protected array $routes = [];
    protected $prefix = '/api';

    /**
     * Add a new route for a GET request
     * 
     * @param string $path
     * @param $callback
     */
    public function get(string $path, $callback)
    {
        $this->addRoute('get', $path, $callback);
    }

    /**
     * Add a new route for a POST request
     * 
     * @param string $path
     * @param $callback
     */
    public function post(string $path, $callback)
    {
        $this->addRoute('post', $path, $callback);
    }

    /**
     * Add a new route for a PUT request
     * 
     * @param string $path
     * @param $callback
     */
    protected function addRoute(string $method, string $path, $callback)
    {
        $route = new Route($method, $path, $callback);
        $this->routes[$method][$path] = $route;
    }

    /**
     * Resolve the current route
     * 
     * @param Request $request
     * @param Response $response
     * @param Container $container
     */
    public function resolve(Request $request, Response $response, Container $container)
    {
        $method = strtolower($request->getMethod());
        $path = $request->getPath();

        if (isset($this->routes[$method][$path])) {
            $route = $this->routes[$method][$path];
            $callback = $route->getCallback();

            if (is_callable($callback)) {
                return call_user_func($callback, $request, $response);
            } elseif (is_string($callback)) {
                return $this->callController($callback, $request, $response, $container);
            }
        }

        $response->setStatusCode(404);
        echo "404 - Route not found";
    }

    /**
     * Call a controller based on the callback string
     * 
     * @param string $callback
     * @param Request $request
     * @param Response $response
     * @param Container $container
     */
    protected function callController(string $callback, Request $request, Response $response, Container $container)
    {
        [$controllerName, $methodName] = explode('@', $callback);

        // Create the controller through the container (for dependency injection)
        $controllerClass = "\\App\\Controllers\\" . $controllerName;
        $controller = $container->get($controllerClass);

        if (method_exists($controller, $methodName)) {
            return call_user_func_array([$controller, $methodName], [$request, $response]);
        }

        $response->setStatusCode(404);
        echo "404 - Method not found";
    }

    /**
     * Get the prefix for the routes
     * 
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }   
}

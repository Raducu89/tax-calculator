<?php
namespace Core;

class App
{
    protected Router $router;
    protected Container $container;

    /**
     * App constructor.
     * 
     * @param Router $router
     * @param Container $container
     */
    public function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    /**
     * Run the application.
     */
    public function run()
    {
        $request = new Request();
        $response = new Response();
        
        // Route the request to the correct controller
        $this->router->resolve($request, $response, $this->container);
    }
}

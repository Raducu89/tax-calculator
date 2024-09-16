<?php

require_once __DIR__ . '/vendor/autoload.php';

use Core\Container;
use Core\App;
use App\Middleware\CorsMiddleware;
use Core\Request;
use Core\Response;

// Initialize the dependency injection container
$container = new Container();

// Register the CORS middleware
$corsMiddleware = new CorsMiddleware();
$corsMiddleware->handle(new Request(), new Response());

// Load the routes from api.php
$router = require __DIR__ . '/app/Routes/api.php';

// Initialize and run the application
$app = new App($router, $container);
$app->run();
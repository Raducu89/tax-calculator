<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\App;
use Core\Container;
use Core\Router;

// Initialize the dependency injection container
$container = new Container();

// Register the services needed
$container->register(App::class, function($container) {
    // Load the routes from config/api.php
    $router = require __DIR__ . '/../config/api.php';
    
    return new App(
        $router, 
        $container
    );
});

// Initialize and run the application
$app = $container->get(App::class);
$app->run();

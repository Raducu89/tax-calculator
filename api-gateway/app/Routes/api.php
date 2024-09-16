<?php

use App\Controllers\ApiGateway;
use Core\Router;

$router = new Router();

// Route for tax service and tax reports
$router->get('/api/tax-service/api/taxes', 'ApiGateway@forward');
$router->post('/api/tax-service/api/taxes/calculate', 'ApiGateway@forward');
// $router->get('/api/tax-reports/*', 'ApiGateway@forward');
// $router->post('/api/tax-reports/*', 'ApiGateway@forward');

return $router;

<?php

use Core\Router;

$router = new Router();
$prefix = $router->getPrefix();

$router->get($prefix. '/taxes', 'TaxController@taxes');
$router->post($prefix. '/taxes/calculate', 'TaxController@calculateTax');

return $router;

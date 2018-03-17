<?php

/**
 * Front controller
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(0);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', [
    'controller' => 'Home',
    'action' => 'index'
]);

$router->add('dynamic/report/getusercount', [
    'controller' => 'Report',
    'action' => 'getUserCount'
]);

$router->add('dynamic/report/getordercount', [
    'controller' => 'Report',
    'action' => 'getOrderCount'
]);

$router->add('dynamic/report/getrevenue', [
    'controller' => 'Report',
    'action' => 'getOrderRevenue'
]);

$router->add('dynamic/report/getgraphdata', [
    'controller' => 'Report',
    'action' => 'getGraphData'
]);




$router->dispatch($_SERVER['QUERY_STRING']);

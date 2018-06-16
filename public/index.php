<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

session_start();

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Page', 'action' => 'aboutUs']);
$router->add('how-it-works', ['controller' => 'Page', 'action' => 'howItWorks']);
$router->add('tech-support', ['controller' => 'Page', 'action' => 'techSupport']);
$router->add('contact', ['controller' => 'Page', 'action' => 'contact']);

if(!session_id())
{
	session_start();
}


$router->dispatch($_SERVER['QUERY_STRING']);

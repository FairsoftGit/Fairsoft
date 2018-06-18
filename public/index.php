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

// Routes to static pages
$router->add('', ['controller' => 'page', 'action' => 'aboutUs', 'namespace' => 'Fairsoft']);
$router->add('how-it-works', ['controller' => 'page', 'action' => 'howItWorks', 'namespace' => 'Fairsoft']);
$router->add('tech-support', ['controller' => 'page', 'action' => 'techSupport', 'namespace' => 'Fairsoft']);
$router->add('contact', ['controller' => 'page', 'action' => 'contact', 'namespace' => 'Fairsoft']);

// Routes to productpages
$router->add('fairVest/{id:\d+}', ['controller' => 'product', 'action' => 'index', 'namespace' => 'Fairsoft']);
$router->add('fairBox/{id:\d+}', ['controller' => 'product', 'action' => 'index', 'namespace' => 'Fairsoft']);
$router->add('fairGoggles/{id:\d+}', ['controller' => 'product', 'action' => 'index', 'namespace' => 'Fairsoft']);
$router->add('fairApp/{id:\d+}', ['controller' => 'product', 'action' => 'index', 'namespace' => 'Fairsoft']);

if(!session_id())
{
	session_start();
}

$router->dispatch($_SERVER['QUERY_STRING']);

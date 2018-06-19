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
$languagePattern = '{language:^[a-zA-Z][a-zA-Z]}';
$idPattern = '{id:\d+}';

//General
$router->add($languagePattern, ['controller' => 'account', 'action' => 'setLanguage', 'namespace' => 'General']);
$router->add($languagePattern, ['controller' => 'shoppingController', 'action' => 'basket', 'namespace' => 'General']);
// Routes to static pages
$router->add('', ['controller' => 'page', 'action' => 'aboutUs']);
$router->add('how-it-works', ['controller' => 'page', 'action' => 'howItWorks']);
$router->add('tech-support', ['controller' => 'page', 'action' => 'techSupport']);
$router->add('contact', ['controller' => 'page', 'action' => 'contact']);

// Routes to productpages
$router->add('fairVest/{id:\d+}', ['controller' => 'product', 'action' => 'index']);
$router->add('fairBox/{id:\d+}', ['controller' => 'product', 'action' => 'index']);
$router->add('fairGoggles/{id:\d+}', ['controller' => 'product', 'action' => 'index']);
$router->add('fairApp/{id:\d+}', ['controller' => 'product', 'action' => 'index']);

// Add the routes
$router->add('', ['controller' => 'Page', 'action' => 'aboutUs']);
$router->add('how-it-works', ['controller' => 'Page', 'action' => 'howItWorks']);
$router->add('tech-support', ['controller' => 'Page', 'action' => 'techSupport']);
$router->add('contact', ['controller' => 'Page', 'action' => 'contact']);
$router->add('login', ['controller' => 'Account', 'action' => 'login', 'namespace' => 'General']);


if(!session_id())
{
	session_start();
}

$router->dispatch($_SERVER['QUERY_STRING']);

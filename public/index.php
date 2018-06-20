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
$router->add('login', ['controller' => 'Account', 'action' => 'login', 'namespace' => 'General']);

// Routes to static pages
$router->add('', ['controller' => 'page', 'action' => 'aboutUs', 'namespace' => 'Fairsoft']);
$router->add('how-it-works', ['controller' => 'page', 'action' => 'howItWorks', 'namespace' => 'Fairsoft']);
$router->add('fairData', ['controller' => 'page', 'action' => 'fairData', 'namespace' => 'Fairsoft']);
$router->add('fairRent', ['controller' => 'page', 'action' => 'fairRent', 'namespace' => 'Fairsoft']);
$router->add('fairPayPlan', ['controller' => 'page', 'action' => 'fairPayPlan', 'namespace' => 'Fairsoft']);
$router->add('tech-support', ['controller' => 'page', 'action' => 'techSupport', 'namespace' => 'Fairsoft']);
$router->add('contact', ['controller' => 'page', 'action' => 'contact', 'namespace' => 'Fairsoft']);
$router->add('cart', ['controller' => 'cart', 'action' => 'showCart', 'namespace' => 'Fairsoft']);


// Routes to productpages
$router->add('fairVest/{id:\d+}', ['controller' => 'product', 'action' => 'index', 'namespace' => 'Fairsoft']);
$router->add('fairBox/{id:\d+}', ['controller' => 'product', 'action' => 'index', 'namespace' => 'Fairsoft']);
$router->add('fairGoggles/{id:\d+}', ['controller' => 'product', 'action' => 'index', 'namespace' => 'Fairsoft']);
$router->add('fairApp/{id:\d+}', ['controller' => 'product', 'action' => 'index', 'namespace' => 'Fairsoft']);

// Testing shoppingcart
$router->add('cart/add/{id:\d+}', ['controller' => 'cart', 'action' => 'add', 'namespace' => 'Fairsoft']);
$router->add('cart/edit/{id:\d+}', ['controller' => 'cart', 'action' => 'edit', 'namespace' => 'Fairsoft']);
$router->add('cart/delete/{id:\d+}', ['controller' => 'cart', 'action' => 'delete', 'namespace' => 'Fairsoft']);




if(!session_id())
{
	session_start();
}

$router->dispatch($_SERVER['QUERY_STRING']);

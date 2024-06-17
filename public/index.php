<?php

// Definim calea către directorul rădăcină al aplicației
require_once __DIR__ . '/../init.php';
define('ROOT_DIR', dirname(__DIR__));

// Include configurația aplicației
require_once ROOT_DIR . '/app/config/config.php';

// Include router-ul aplicației din directorul app
require_once ROOT_DIR . '/app/Router.php';

// Instantiate the router and dispatch the request
$router = new Router();
$router->dispatch();
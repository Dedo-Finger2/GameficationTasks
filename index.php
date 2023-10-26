<?php 

require __DIR__."/vendor/autoload.php";

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Routes\Router;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

Router::add('GET', '/', [HomeController::class, 'index']);
Router::add('GET', '/users', [UserController::class, 'index']);
Router::add('GET', '/user/{id:[0-9]+}', [UserController::class, 'show']);


Router::run();

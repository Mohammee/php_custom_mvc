<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Controller\Home;
use App\Controller\LoginController;
use App\Controller\TransactionController;
use App\Route;


//start session
session_start();

//autoload
require dirname(__DIR__).'/'.'vendor/'.'autoload.php';

define('__VIEW_PATH__', dirname(__DIR__).'/views/');
define('__CSV_PATH__', dirname(__DIR__).'/csv');

//dotenv
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//routes
$route = new Route();

$route
    ->get('/', [Home::class, 'index'])
    ->get('/profile', [TransactionController::class, 'index']);

$route
    ->get('/login', [LoginController::class, 'loginForm'])
    ->get('/logout', [LoginController::class, 'logout'])
    ->post('/login', [LoginController::class, 'login']);

(new App($route, strtolower($_SERVER['REQUEST_METHOD']), $_SERVER['REQUEST_URI'], new Config($_ENV)))->run();





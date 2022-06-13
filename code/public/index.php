<?php

require_once '../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\App;

$config = [
	'db' => [
		'dsn' => $_ENV['DB_DSN'],
		'user' => $_ENV['DB_USER'],
		'password' => $_ENV['DB_PASSWORD']
	]
];

$app = new App($config);

$app->router->get('/', [SiteController::class, 'welcome']);

$app->router->get('/auth', [AuthController::class, 'authEmail']);
$app->router->post('/auth', [AuthController::class, 'auth']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->run();
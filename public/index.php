<?php

use Slim\Factory\AppFactory;

require_once('../inc/common.inc.php');

$app = \DI\Bridge\Slim\Bridge::create();

$app->get('/task/complited', [TaskController::class, 'completedTasks']);

$app->get('/task/unfinished', [TaskController::class, 'unfinishedTasks']);

$app->post('/task/add', [TaskController::class, 'add']);

$app->get('/task/delete/{id}', [TaskController::class, 'delete']);

$app->get('/task/complete/{id}', [TaskController::class, 'complete']); 


$app->run();

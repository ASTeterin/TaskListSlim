<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require_once('../inc/common.inc.php');

$app = \DI\Bridge\Slim\Bridge::create();


$app->get('/task/complited', function (Request $request, Response $response) 
{
    $database = new Database();
    $db = $database->getConnection();
    $taskRepository = new TaskRepository($db);
    $complitedTasks = $taskRepository->getTasksByValue(Config::IS_DONE, Config::TASK_IS_DONE);
    $response->getBody()->write(json_encode($complitedTasks));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->get('/task/unfinished', function (Request $request, Response $response) 
{
    $database = new Database();
    $db = $database->getConnection();
    $taskRepository = new TaskRepository($db);
    $unfinishedTasks = $taskRepository->getTasksByValue(Config::IS_DONE, Config::TASK_IS_NOT_COMPLETED);
    $response->getBody()->write(json_encode($unfinishedTasks));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->post('/task/add', [TaskController::class, 'add']);

$app->get('/task/delete/{id}', [TaskController::class, 'delete']);

$app->get('/task/complete/{id}', function (Request $request, Response $response) 
{
    $idTask = $request->getAttribute('id');
    $database = new Database();
    $db = $database->getConnection();
    $taskRepository = new TaskRepository($db);
    $data = [Config::IS_DONE => Config::TASK_IS_DONE];
    if (!$taskRepository->getTaskById($idTask)) 
    {
        return $response->withJson(ResponseConfig::NO_TASK, 404);   
    }
    $result = $taskRepository->update($idTask, $data);

    return (isset($result))? $response->withJson(ResponseConfig::SUCCESSFUL_RESULT, 200): $response->withJson(ResponseConfig::SERVER_ERROR, 500);    
});

$app->run();

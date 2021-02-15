<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once('../inc/common.inc.php');

$app = new \Slim\App();

$app->get('/task/complited', function(Request $request, Response $response) 
{
    $result = TaskController::getDataByIsDone(Config::TASK_IS_DONE);
    return $response->withJson($result,200);
});

$app->get('/task/unfinished', function(Request $request, Response $response) 
{
    $result = TaskController::getDataByIsDone(Config::TASK_IS_NOT_COMPLETED);
    return $response->withJson($result,200);
});


$app->post('/task/add', function(Request $request, Response $response)
{
    $requestData = $request->getParsedBody();
    if (checkAddRequest($requestData) <> TaskError::ERR_NO_ERROR) 
    {
        return $response->withJson(ResponseConfig::BAD_REQUEST,400);      
    }
    $result = TaskController::addNewTask($requestData);
    return (isset($result))? $response->withJson(ResponseConfig::SUCCESSFUL_RESULT,200): $response->withJson(ResponseConfig::SERVER_ERROR,500);  
});


$app->get('/task/delete/{id}', function (Request $request, Response $response) 
{
    $idTask = $request->getAttribute('id');
    $database = new Database();
    $db = $database->getConnection();
    $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
    if (!$task->getTaskById($idTask)) 
    {
        return $response->withJson(ResponseConfig::NO_TASK,404);   
    }
    $result = $task->delete($idTask);

    return (isset($result))? $response->withJson(ResponseConfig::SUCCESSFUL_RESULT,200): $response->withJson(ResponseConfig::SERVER_ERROR,500);    
});

$app->get('/task/complete/{id}', function (Request $request, Response $response) 
{
    $idTask = $request->getAttribute('id');
    $database = new Database();
    $db = $database->getConnection();
    $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
    $data = [Config::IS_DONE => Config::TASK_IS_DONE];
    if (!$task->getTaskById($idTask)) 
    {
        return $response->withJson(ResponseConfig::NO_TASK,404);   
    }
    $result = $task->update($idTask, $data);

    return (isset($result))? $response->withJson(ResponseConfig::SUCCESSFUL_RESULT,200): $response->withJson(ResponseConfig::SERVER_ERROR,500);    
});

$app->run();

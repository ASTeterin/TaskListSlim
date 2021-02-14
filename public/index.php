<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once('../inc/common.inc.php');


$app = new \Slim\App();
//$app = new \Slim\Slim();

function echoResponse($status_code, $response)
{
    //Getting app instance
    $app = \Slim\Slim::getInstance();
 
    //Setting Http response code
    $app->status($status_code);
 
    //setting response content type to json
    $app->contentType('application/json');
 
    //displaying the response in json format
    echo json_encode($response);
}


$app->get('/task/{is_done}', function(Request $request, Response $response) 
{
    $isDone = $request->getAttribute('is_done');
    $database = new Database();
    $db = $database->getConnection();
    $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
    $data = getDataFromRequest();
    $result = $task->getTasksByIsDone($isDone);
    return $response->withJson($result,200);
});


$app->post('/task/add', function(Request $request, Response $response)
{
    $request_data = $request->getParsedBody();
    if (checkAddRequest($request_data) <> TaskError::ERR_NO_ERROR) 
    {
        return $response->withJson(ResponseData::BAD_REQUEST,400);      
    }

    $database = new Database();
    $db = $database->getConnection();
    $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
    $result = $task->add($request_data);
    //echo $result;
    if (isset($result)) 
    {
        return $response->withJson(ResponseData::SUCCESSFUL_RESULT,200);   
    }
    else
    {
        return $response->withJson(ResponseData::SERVER_ERROR,500);    
    }
});


$app->get('/task/delete/{id}', function (Request $request, Response $response) 
{
    $idTask = $request->getAttribute('id');
    $database = new Database();
    $db = $database->getConnection();
    $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
    if (!$task->getTaskById($idTask)) 
    {
        return $response->withJson(ResponseData::NO_TASK,404);   
    }
    $result = $task->delete($idTask);

    if (isset($result)) 
    {
        return $response->withJson(ResponseData::SUCCESSFUL_RESULT,200);   
    }
    else
    {
        return $response->withJson(ResponseData::SERVER_ERROR,500);    
    }
});

$app->get('/task/make/{id}', function (Request $request, Response $response) 
{
    $idTask = $request->getAttribute('id');
    $database = new Database();
    $db = $database->getConnection();
    $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
    if (!$task->getTaskById($idTask)) 
    {
        return $response->withJson(ResponseData::NO_TASK,404);   
    }
    $result = $task->makeDone($idTask);

    if (isset($result)) 
    {
        return $response->withJson(ResponseData::SUCCESSFUL_RESULT,200);   
    }
    else
    {
        return $response->withJson(ResponseData::SERVER_ERROR,500);    
    }
});

$app->run();

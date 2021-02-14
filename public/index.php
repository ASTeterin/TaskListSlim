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


$app->get('/task/{is_done}', function (Request $request, Response $response) {
    $isDone = $request->getAttribute('is_done');
    $database = new Database();
    $db = $database->getConnection();
    $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
    $data = getDataFromRequest();
    $result = $task->getTasksByIsDone($isDone);
    return $response->withJson($result,200);
});



$app->get('/task/delete/{id}', function (Request $request, Response $response) {
    //$this->logger->addInfo("Ticket list");
    //$mapper = new TicketMapper($this->db);
    //$tickets = $mapper->getTickets();
    $idTask = $request->getAttribute('id');
    $database = new Database();
    $db = $database->getConnection();
    $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
    if (!$task->getTaskById($idTask)) 
    {
        $bad = ['error' => 'Task is missing'];
        return $response->withJson($bad,404);   
    }


    $result = $task->delete($idTask);

    if (isset($result)) 
    {
        //$response->withJson($good,200); 
        $good = ['result' => 'Success'];
        return $response->withJson($good,200);   
    }
    else
    {
        $bad = ['error' => 'Server error'];
        return $response->withJson($bad,500);    
    }
});

$app->run();

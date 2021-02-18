<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;


class TaskController
{
    private $taskRepository;
    private $db;
    private $database;

    public function __construct(TaskRepository $taskRepository, Database $database)
    {
        $this->taskRepository = $taskRepository;
    }

    public function delete(int $id, Response $response): Response
    {
        if (!$this->taskRepository->getTaskById($id))
        {
            $response->getBody()->write(json_encode(ResponseConfig::NO_TASK));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $result = $this->taskRepository->delete($id);
        if (isset($result))
        {
            $response->getBody()->write(json_encode(ResponseConfig::SUCCESSFUL_RESULT));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);    
        }
        else
        {
            $response->getBody()->write(json_encode(ResponseConfig::SERVER_ERROR));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);       
        }     
    }

    public function add(Request $request, Response $response): Response
    {
        $requestData = getJSONFromRequest($request);
        if ((!isset($requestData)) || (checkAddRequest($requestData) <> TaskError::ERR_NO_ERROR)) 
        {
            $response->getBody()->write(json_encode(ResponseConfig::BAD_REQUEST));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);    
        }
        $result = $this->taskRepository->add($requestData);
        
        if (isset($result))
        {
            $response->getBody()->write(json_encode(ResponseConfig::SUCCESSFUL_RESULT));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);    
        }
        else
        {
            $response->getBody()->write(json_encode(ResponseConfig::SERVER_ERROR));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);       
        }    
    }
    public function complete(int $id, Response $response): Response
    {
        if (!$this->taskRepository->getTaskById($id)) 
        {
            $response->getBody()->write(json_encode(ResponseConfig::NO_TASK));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $result = $this->taskRepository->update($id, [Config::IS_DONE => Config::TASK_IS_COMPLETED]);
        if (isset($result))
        {
            $response->getBody()->write(json_encode(ResponseConfig::SUCCESSFUL_RESULT));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);    
        }
        else
        {
            $response->getBody()->write(json_encode(ResponseConfig::SERVER_ERROR));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);       
        }     

    }

    public function unfinishedTasks(Response $response): Response
    {
        $unfinishedTasks = $this->taskRepository->getTasksByValue(Config::IS_DONE, Config::TASK_IS_NOT_COMPLETED);
        if (isset($unfinishedTasks))
        {
            $response->getBody()->write(json_encode($unfinishedTasks));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        }
        else
        {
            $response->getBody()->write(json_encode(ResponseConfig::SERVER_ERROR));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);    
        }      
    }

    public function completedTasks(Response $response): Response
    {
        $unfinishedTasks = $this->taskRepository->getTasksByValue(Config::IS_DONE, Config::TASK_IS_COMPLET);
        if (isset($unfinishedTasks))
        {
            $response->getBody()->write(json_encode($unfinishedTasks));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);  
        }
        else
        {
            $response->getBody()->write(json_encode(ResponseConfig::SERVER_ERROR));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);    
        }
    }   
}

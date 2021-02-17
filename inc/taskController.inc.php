<?php

class TaskController
{
    private $taskRepository;
    private $db;
    private $database;

    public function __construct(TaskRepository $taskRepository, Database $database)
    {
        $this->taskRepository = $taskRepository;
    }

    public function delete($id, $response)
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
}

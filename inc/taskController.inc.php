<?php

class TaskController
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function delete($request, $response)
    {
        //$taskRepository = $tasController->taskRepository;
        if (!$this->taskRepository->getTaskById($idTask)) 
        {
            $response->getBody()->write(json_encode(ResponseConfig::NO_TASK));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $result = $this->taskRepository->delete($idTask);
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

// Notice how we register the controller using the class name?
// PHP-DI will instantiate the class for us only when it's actually necessary

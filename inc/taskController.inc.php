<?php

class TaskController
{
    public static function getDataByIsDone($isDone): ?array
    {
        $database = new Database();
        $db = $database->getConnection();
        $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
        $result = $task->getTasksByValue(Config::IS_DONE, $isDone);
        return $result;
    }

    public static function addNewTask($taskData): ?int
    {
        $database = new Database();
        $db = $database->getConnection();
        $task = RepositoryFactory::build(Config::TYPE_REPOSITORY, $db);
        $result = $task->add($taskData);
        return $result;
    }
}
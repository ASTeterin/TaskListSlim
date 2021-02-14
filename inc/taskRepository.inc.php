<?php

class TaskRepository 
{
    private $db = null;
    private $tableName = Config::TABLE;

    public function __construct($db) 
    {
        $this->db = $db;     
    }

    public function getTasksByIsDone($isDone): ?array 
    {
        $this->db->where(Config::IS_DONE, $isDone);
        $task = $this->db->get($this->tableName);
        return (isset($task)) ? $task : null; 
    }

    public function delete($id): ?int 
    {
        $this->db->where(Config::ID_TASK, $id);
        return ($this->db->delete($this->tableName))? $id : null ;
    }

    public function add($data): ?int 
    {
        $id = $this->db->insert(Config::TABLE, $data);
        return (isset($id)) ? $id : null;    

    }

    public function makeDone($id): ?int 
    {
        $data = ['is_done' => Config::TASK_IS_DONE];
        $this->db->where(Config::ID_TASK, $id);
        return ($this->db->update(Config::TABLE, $data))? $id : null;
    }

    public function getTaskById($id): ?array 
    {
        $this->db->where(Config::ID_TASK, $id);
        $task = $this->db->get($this->tableName);
        return (isset($task)) ? $task : null; 
    }
}
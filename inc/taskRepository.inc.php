<?php

class TaskRepository 
{
    private $db = null;
    private $tableName = Config::TABLE;

    public function __construct($db) 
    {
        $this->db = $db;     
    }

    public function getTasksByValue(string $column, $value): ?array 
    {
        $this->db->where($column, $value);
        $task = $this->db->get($this->tableName);
        return (isset($task)) ? $task : null; 
    }

    public function delete(int $id): ?int 
    {
        $this->db->where(Config::ID_TASK, $id);
        return ($this->db->delete($this->tableName))? $id : null ;
    }

    public function add(array $data): ?int 
    {
        $id = $this->db->insert(Config::TABLE, $data);
        return (isset($id)) ? $id : null;    

    }

    public function update(int $id, array $data): ?int 
    {
        $this->db->where(Config::ID_TASK, $id);
        return ($this->db->update(Config::TABLE, $data))? $id : null;
    }

    public function getTaskById(int $id): ?array 
    {
        $this->db->where(Config::ID_TASK, $id);
        $task = $this->db->get($this->tableName);
        return (isset($task)) ? $task : null; 
    }
}
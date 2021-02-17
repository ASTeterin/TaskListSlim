<?php

class Database {

    private $host = Config::HOST;
    private $db_name = Config::DATABASE;
    private $username = Config::USER;
    private $password = Config::PASSWORD;
    public $db;

    public function __construct()
    {
        $this->db = new MysqliDb($this->host, $this->username, $this->password, $this->db_name);
    }   
}
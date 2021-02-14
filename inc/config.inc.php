<?php

class Config
{
    public const MAX_TASK_TEXT_LEN = 1000;
    public const HOST = '127.0.0.1';
    public const USER = 'root';
    public const PASSWORD = 'Qwerty123';
    public const DATABASE = 'task';
    public const TABLE = 'task';
    public const TYPE_REPOSITORY = 'Task'; 
    public const ID_TASK = 'id_task';
    public const IS_DONE = 'is_done';
    public const TASK_IS_DONE = 1;
    public const TASK_IS_NOT_COMPLETED = 0;
    public const COLUMN_NAMES = ['task_name', 'task_text', 'is_done'];
}

<?php
class Response
{
    public const SUCCESSFUL_RESULT = ['result' => 'Success'];
    public const BAD_REQUEST = ['error' => 'Bad Request'];
    public const NO_TASK = ['error' => 'Task is missing'];
    public const SERVER_ERROR = ['error' => 'Server error'];

    public const STATUS_200 = 'HTTP/1.0 200 200 OK ';
    public const STATUS_400 = 'HTTP/1.0 400 Bad request';
    public const STATUS_404 = 'HTTP/1.0 404 Not found';
    public const STATUS_500 = 'HTTP/1.0 500 Internal Server Error';

    public static function generateResponse($status, $data): void
    {
        header($status);
        echo json_encode($data);    
    }

}
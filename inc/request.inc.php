<?php
use Psr\Http\Message\ServerRequestInterface as Request;

function checkAddRequest(array $data): ?int 
{
    if (!isset($data))
        return null;
    foreach($data as $key => $value) 
    {
        if (!in_array($key, Config::COLUMN_NAMES)) 
        {
            return TaskError::ERR_COLUMN_NAME;
        }
        if (strlen($value) > Config::MAX_TASK_TEXT_LEN) 
        {
            return TaskError::ERR_MAX_LEN_TEXT;
        }
    }
    return TaskError::ERR_NO_ERROR;   
}

function getJSONFromRequest(Request $request): ?array
{
    $contentType = $request->getHeaderLine('Content-Type');
    if (strstr($contentType, 'application/json')) 
    {
        $contents = json_decode(file_get_contents('php://input'), true);
        $request = $request->withParsedBody($contents); 
        return $request->getParsedBody();  
    }
    else
    {
        return TaskError::ERR_BAD_REQUEST_TYPE;
    }
}

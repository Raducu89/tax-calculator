<?php
namespace Core;

class Response
{   
    /**
     * Set the HTTP status code.
     * 
     * @param int $code
     */
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    /**
     * Send a JSON response.
     * 
     * @param array $data
     * @param int $statusCode
     */
    public function json(array $data, int $statusCode = 200)
    {
        header('Content-Type: application/json', true, $statusCode);
        echo json_encode($data);
    }
}

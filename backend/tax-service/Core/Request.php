<?php
namespace Core;

class Request
{   
    /**
     * Get the HTTP method.
     * 
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Get the path.
     * 
     * @return string
     */
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    /**
     * Get the body.
     * 
     * @return array
     */
    public function getBody(): array
    {
        if ($this->getMethod() === 'get') {
            return $_GET; // Handle GET parameters
        }

        if ($this->getMethod() === 'post') {
            // Handle JSON or form data for POST requests
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            
            if (strpos($contentType, 'application/json') !== false) {
                // Handle JSON request body
                $input = file_get_contents('php://input');
                return json_decode($input, true) ?? [];
            } else {
                // Handle form-urlencoded or multipart form data
                return $_POST;
            }
        }

        return [];
    }

    /**
     * Get the headers.
     * 
     * @return array
     */
    public function getHeaders(): array
    {
        return getallheaders();
    }
}

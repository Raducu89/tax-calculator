<?php

namespace App\Middleware;

use Core\Request;
use Core\Response;

class CorsMiddleware
{   
    /**
     * Handle the CORS preflight request.
     * 
     * @param Request $request
     * @param Response $response
     * @return bool
     */
    public function handle(Request $request, Response $response)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($request->getMethod() === 'options') {
            header("HTTP/1.1 200 OK");
            exit();
        }

        return true;
    }
}

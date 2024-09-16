<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Core\Request;
use Core\Response;

class ApiGateway
{
    protected $client;
    protected $services;

    /**
     * ApiGateway constructor.
     * 
     * Initialize the Guzzle client and load the services configuration.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->services = require __DIR__ . '/../../config/services.php'; // Configuration of microservices URLs
    }

    /**
     * Forward the request to the correct microservice.
     * 
     * @param Request $request
     * @param Response $response
     */
    public function forward(Request $request, Response $response)
    {
        $path = $request->getPath();
        // Check if the path includes the /api/tax-service prefix
        $service = $this->getServiceFromPath($path);

        if ($service) {
            // We keep the rest of the path starting with /api
            $newPath = $this->stripServicePrefix($path, '/api/tax-service');
            $this->proxyRequest($service, $newPath, $request, $response);
        } else {
            $response->json(['error' => 'Service not found'], 404);
        }
    }

    /**
     * Get the correct microservice URL based on the path.
     * 
     * @param string $path
     * @return string|null
     */
    protected function getServiceFromPath($path)
    {
        // Match the partial path for /api/tax-service/*
        if (preg_match('/^\/api\/tax-service(\/.*)?$/', $path)) {
            return $this->services['tax_service'];
        } elseif (preg_match('/^\/api\/tax-reports(\/.*)?$/', $path)) {
            return $this->services['tax_reports'];
        }

        return null;
    }

    /**
     * Remove the service prefix from the path.
     * 
     * @param string $path
     * @param string $prefix
     * @return string
     */
    protected function stripServicePrefix($path, $prefix)
    {
        // Keep only /api and the rest of the path
        return str_replace($prefix, '', $path);
    }

    /**
     * Proxy the request to the microservice.
     * 
     * @param string $serviceUrl
     * @param string $path
     * @param Request $request
     * @param Response $response
     */
    protected function proxyRequest($serviceUrl, $path, Request $request, Response $response)
    {   
        try {
            // Concatenate the correct path with the microservice URL
            $proxyResponse = $this->client->request($request->getMethod(), $serviceUrl . $path, [
                'headers' => $this->getHeaders(),
                'json' => $request->getBody()
            ]);

            // Return the microservice response to the client
            $response->setStatusCode($proxyResponse->getStatusCode());
            echo $proxyResponse->getBody();
        } catch (RequestException $e) {
            $response->setStatusCode(503);
            $response->json(['error' => 'Service unavailable', 'exception' => $e->getMessage()]);
        }
    }

    /**
     * Get the necessary headers for the microservices to accept the request.
     * 
     * @return array
     */
    protected function getHeaders()
    {
        // Necessary headers for the microservices to accept the request
        return [
            'Content-Type' => 'application/json',
        ];
    }
}

<?php

namespace Core;

class Route
{
    protected string $method;
    protected string $path;
    protected $callback;

    /**
     * Route constructor.
     * 
     * @param string $method
     * @param string $path
     * @param $callback
     */
    public function __construct(string $method, string $path, $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    /**
     * Get the HTTP method.
     * 
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get the path.
     * 
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the callback.
     * 
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }
}

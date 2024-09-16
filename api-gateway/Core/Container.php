<?php
namespace Core;

use ReflectionClass;
use ReflectionNamedType;
use Exception;

class Container
{
    protected array $bindings = [];

    /**
     *  Register a service in the container
     **/
    public function register(string $abstract, callable $factory)
    {
        $this->bindings[$abstract] = $factory;
    }

    /**
     *  Optain a service or an instance of a class from the container
     *  
     * @param string $abstract
     * @return mixed
     */
    public function get(string $abstract)
    {
        // Check if the service is registered
        if (isset($this->bindings[$abstract])) {
            return $this->bindings[$abstract]($this);
        }

        // If it's not registered, try to resolve it automatically
        return $this->resolve($abstract);
    }

    /**
     *  Resolves the dependencies of a class
     * 
     * @param string $abstract
     * @return mixed
     */
    public function resolve(string $abstract)
    {
        // Check if it's an interface and apply the naming convention
        if (interface_exists($abstract)) {
            $concrete = str_replace('Interfaces', 'Repositories', $abstract);
            $concrete = str_replace('Interface', '', $concrete);

            if (class_exists($concrete)) {
                $abstract = $concrete;
            } else {
                throw new Exception("No concrete class found for interface {$abstract}");
            }
        }

        // Check if the class exists
        if (!class_exists($abstract)) {
            throw new Exception("Class {$abstract} does not exist");
        }

        // Use ReflectionClass to get details about the class
        $reflection = new ReflectionClass($abstract);

        // Check if the class is instantiable (not abstract or an interface)
        if (!$reflection->isInstantiable()) {
            throw new Exception("Class {$abstract} is not instantiable");
        }

        // Optain the class constructor
        $constructor = $reflection->getConstructor();

        // If there is no constructor, we create a simple instance
        if (is_null($constructor)) {
            return new $abstract;
        }

        // Optain the constructor parameters (dependencies)
        $parameters = $constructor->getParameters();
        $dependencies = [];

        // Iterating through the constructor parameters and trying to resolve them
        foreach ($parameters as $parameter) {
            // Optain the parameter type
            $parameterType = $parameter->getType();
        
            // Check if it's a class type and not a native type (e.g., scalar)
            if ($parameterType instanceof ReflectionNamedType && !$parameterType->isBuiltin()) {
                $dependency = new ReflectionClass($parameterType->getName());
            } else {
                $dependency = null;
            }
        
            // If the dependency is not a class (e.g., a scalar), we check for a default value
            if ($dependency === null) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new Exception("Cannot resolve non-class dependency: " . $parameter->getName() . " in class " . $abstract);
                }
            } else {
                // If the dependency is a class, we try to get it from the container
                $dependencies[] = $this->get($dependency->getName());
            }
        }
        
        // Instantiate the class with the resolved dependencies
        return $reflection->newInstanceArgs($dependencies);
    }
}

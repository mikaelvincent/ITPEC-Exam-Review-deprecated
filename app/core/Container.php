<?php

namespace App\Core;

use ReflectionClass;
use ReflectionNamedType;

/**
 * A simple Dependency Injection Container to manage object creation and dependencies.
 */
class Container
{
    /**
     * The container's bindings.
     *
     * @var array
     */
    protected array $bindings = [];

    /**
     * The container's singleton instances.
     *
     * @var array
     */
    protected array $singletons = [];

    /**
     * Binds a class or interface to a concrete implementation or closure.
     *
     * @param string $abstract
     * @param callable|string|null $concrete
     * @return void
     */
    public function bind(string $abstract, $concrete = null): void
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Binds a singleton instance to the container.
     *
     * @param string $abstract
     * @param mixed $instance
     * @return void
     */
    public function bindSingleton(string $abstract, $instance): void
    {
        $this->singletons[$abstract] = $instance;
    }

    /**
     * Resolves and returns an instance of the given class or interface.
     *
     * @param string $abstract
     * @return mixed
     * @throws \Exception
     */
    public function make(string $abstract)
    {
        if (isset($this->singletons[$abstract])) {
            return $this->singletons[$abstract];  // Return singleton instance if available
        }

        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];

            if ($concrete instanceof \Closure) {
                return $concrete($this);
            }

            return $this->build($concrete);
        }

        return $this->build($abstract);
    }

    /**
     * Builds an instance of the given class, injecting its dependencies.
     *
     * @param string $concrete
     * @return mixed
     * @throws \Exception
     */
    protected function build(string $concrete)
    {
        if (!class_exists($concrete)) {
            throw new \Exception("Class {$concrete} does not exist.");
        }

        $reflector = new \ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$concrete} is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $concrete;
        }

        $parameters = $constructor->getParameters();

        $dependencies = $this->resolveDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * Resolves an array of constructor parameters.
     *
     * @param array $parameters
     * @return array
     * @throws \Exception
     */
    protected function resolveDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $dependencies[] = $this->make($type->getName());
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new \Exception("Cannot resolve dependency {$parameter->name}");
            }
        }

        return $dependencies;
    }
}

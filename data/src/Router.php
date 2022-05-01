<?php

namespace Rakke1\TestMvc;

use ArrayObject;
use Rakke1\TestMvc\Exception\NotFoundException;

final class Router
{
    private const NO_ROUTE = 404;

    private ArrayObject $routes;

    public function __construct(array $routes = [])
    {
        $this->routes = new ArrayObject();
        foreach ($routes as $route) {
            $this->add($route);
        }
    }
    public function add(Route $route): self
    {
        $this->routes->offsetSet($route->getName(), $route);
        return $this;
    }

    public function matchFromPath(string $pathWithQuery, string $method): Route
    {
        /** @var Route $route */
        foreach ($this->routes as $route) {
            if ($route->match($pathWithQuery, $method) === false) {
                continue;
            }
            return $route;
        }

        throw new NotFoundException(
            'No route found for ' . $method,
            self::NO_ROUTE
        );
    }

    public static function get(string $name, string $path, array $parameters): Route
    {
        return new Route($name, $path, $parameters);
    }

    public static function post(string $name, string $path, array $parameters): Route
    {
        return new Route($name, $path, $parameters, ['POST']);
    }

    public static function put(string $name, string $path, array $parameters): Route
    {
        return new Route($name, $path, $parameters, ['PUT']);
    }

    public static function delete(string $name, string $path, array $parameters): Route
    {
        return new Route($name, $path, $parameters, ['DELETE']);
    }
}
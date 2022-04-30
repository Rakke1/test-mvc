<?php

namespace Rakke1\TestMvc;

class Route
{
    private string $name;

    private string $path;

    private mixed $handler;

    private array $methods = [];

    private array $attributes = [];

    /*
    * @param string $name
    * @param string $path
    * @param mixed $handler
    *    $handler = [
    *      0 => (string) Controller name : HomeController::class.
    *      1 => (string|null) Method name or null if invoke method
    *    ]
    * @param array $methods
    */
    public function __construct(string $name, string $path, $handler, array $methods = ['GET'])
    {
        if ($methods === []) {
            throw new \InvalidArgumentException('HTTP methods argument was empty; must contain at least one method');
        }
        $this->name = $name;
        $this->path = $path;
        $this->handler = $handler;
        $this->methods = $methods;
    }

    public function match(string $path, string $method): bool
    {
        $regexRoutePath = $this->getPath();
        foreach ($this->getAttributeNames() as $attributeName) {
            $trimmedAttributeName = trim($attributeName, '{\}');
            $regexRoutePath = str_replace($attributeName, '(?P<' . $trimmedAttributeName . '>[^/]++)', $regexRoutePath);
        }

        $trimmedPath = '/' . rtrim(ltrim(trim($path), '/'), '/');
        if (in_array($method, $this->getMethods()) && preg_match('#^' . $regexRoutePath . '$#sD', $trimmedPath, $matches)) {
            $values = array_filter($matches, static function ($key) {
                return is_string($key);
            }, ARRAY_FILTER_USE_KEY);
            foreach ($values as $key => $value) {
                $this->attributes[$key] = $value;
            }
            return true;
        }
        return false;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getAttributeNames(): array
    {
        preg_match_all('/{[^}]*}/', $this->path, $matches);
        $match = reset($matches);
        if ($match === false) {
            return [];
        }
        return $match;
    }

    public function hasAttributes(): bool
    {
        return $this->getAttributeNames() !== [];
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
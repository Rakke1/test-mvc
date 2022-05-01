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

    public function match(string $pathWithQuery, string $method): bool
    {
        $path = parse_url($pathWithQuery, PHP_URL_PATH);
        $regexRoutePath = $this->getPath();
        $pathMatched = preg_match('#^' . $regexRoutePath . '$#sD', $path, $matches);
        $methodExist = in_array($method, $this->getMethods(), true);

        if ($methodExist && $pathMatched) {
            $this->parseAttributes($pathWithQuery);
            return true;
        }
        return false;
    }

    protected function parseAttributes(string $pathWithQuery): void
    {
        $queryParams = [];
        parse_str(parse_url($pathWithQuery, PHP_URL_QUERY), $queryParams);
        foreach ($queryParams as $key => $param) {
            $this->setAttribute($key, $param);
        }
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

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttribute($attribute, $value): void
    {
        $this->attributes[$attribute] = $value;
    }
}
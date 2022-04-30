<?php

namespace Rakke1\TestMvc;

use Psr\Http\Message\ServerRequestInterface;
use Rakke1\TestMvc\Exception\NotFoundException;

interface RouterInterface
{
    /**
     * @param ServerRequestInterface $serverRequest
     * @return Route
     * @throws NotFoundException if no found route.
     */
    public function match(ServerRequestInterface $serverRequest): Route;

    /**
     * @param string $path
     * @param string $method
     * @return Route
     * @throws NotFoundException if no found route.
     */
    public function matchFromPath(string $path, string $method): Route;
}
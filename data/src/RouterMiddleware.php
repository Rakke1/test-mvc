<?php

namespace Rakke1\TestMvc;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Rakke1\TestMvc\Exception\NotFoundException;

class RouterMiddleware implements MiddlewareInterface
{
    public const CONTROLLER = '_controller';
    public const ACTION = '_action';
    public const NAME = '_name';

    private RouterInterface $router;
    private ResponseFactoryInterface $responseFactory;

    public function __construct(
        RouterInterface $router,
        ResponseFactoryInterface $responseFactory
    ) {
        $this->router = $router;
        $this->responseFactory = $responseFactory;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            $route = $this->router->match($request);
            $routeHandler = $route->getHandler();
            $attributes = array_merge([
                self::CONTROLLER => $routeHandler[0],
                self::ACTION => $routeHandler[1] ?? null,
                self::NAME => $route->getName(),
            ], $route->getAttributes());

            foreach ($attributes as $key => $value) {
                $request = $request->withAttribute($key, $value);
            }
        } catch (NotFoundException) {
            return $this->responseFactory->createResponse(404);
        } catch (\Throwable $exception) {
            throw $exception;
        }
        return $handler->handle($request);
    }
}

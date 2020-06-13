<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Json\Json;
use Laminas\Json\Server\Request;
use Laminas\Json\Server\Server as LaminasServer;
use Laminas\Json\Server\Smd;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class Server
 * @package Umirode\JsonRpcServer
 */
final class Server implements RequestHandlerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var LaminasServer
     */
    private $laminasServer;

    /**
     * Server constructor.
     * @param ContainerInterface $container
     * @param LaminasServer $laminasServer
     */
    public function __construct(ContainerInterface $container, LaminasServer $laminasServer)
    {
        $this->container = $container;
        $this->laminasServer = $laminasServer;

        $this->configureLaminasServer();
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() === 'GET') {
            return $this->handleSmdRequest();
        }

        return $this->handleServiceRequest($request);
    }

    /**
     * @param string $class
     * @param string|null $namespace
     */
    public function addService(string $class, ?string $namespace = null): void
    {
        $this->laminasServer->setClass(
            $this->container->get($class),
            $namespace ?: ''
        );
    }

    private function configureLaminasServer(): void
    {
        $this->laminasServer->setReturnResponse();
        $this->laminasServer->setEnvelope(Smd::ENV_JSONRPC_2);
    }

    /**
     * @return ResponseInterface
     */
    private function handleSmdRequest(): ResponseInterface
    {
        return new JsonResponse($this->laminasServer->getServiceMap()->toArray());
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    private function handleServiceRequest(ServerRequestInterface $request): ResponseInterface
    {
        $jsonRpcRequest = new Request();
        $jsonRpcRequest->loadJson(Json::encode($request->getParsedBody()));

        $response = $this->laminasServer->handle($jsonRpcRequest);

        return new JsonResponse(Json::decode((string)$response, Json::TYPE_ARRAY));
    }
}

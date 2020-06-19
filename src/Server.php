<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Umirode\JsonRpcServer\Laminas\LaminasServer;

/**
 * Class Server
 * @package Umirode\JsonRpcServer
 */
final class Server implements ServerInterface
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
     * @var ServiceRequestHandler
     */
    private $serviceRequestHandler;

    /**
     * @var SmdRequestHandler
     */
    private $smdRequestHandler;

    /**
     * Server constructor.
     * @param ContainerInterface $container
     * @param LaminasServer $laminasServer
     * @param ServiceRequestHandler $serviceRequestHandler
     * @param SmdRequestHandler $smdRequestHandler
     */
    public function __construct(
        ContainerInterface $container,
        LaminasServer $laminasServer,
        ServiceRequestHandler $serviceRequestHandler,
        SmdRequestHandler $smdRequestHandler
    ) {
        $this->container = $container;
        $this->laminasServer = $laminasServer;
        $this->serviceRequestHandler = $serviceRequestHandler;
        $this->smdRequestHandler = $smdRequestHandler;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->serviceRequestHandler->setLaminasServer($this->laminasServer);

        if ($request->getMethod() === 'GET') {
            return $this->smdRequestHandler->handle($request);
        }

        return $this->serviceRequestHandler->handle($request);
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
}

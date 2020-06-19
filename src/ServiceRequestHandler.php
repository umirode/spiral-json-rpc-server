<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Umirode\JsonRpcServer\Laminas\LaminasServer;
use Umirode\JsonRpcServer\Laminas\RequestConverter;
use Umirode\JsonRpcServer\Laminas\ResponseConverter;

/**
 * Class ServiceRequestHandler
 * @package Umirode\JsonRpcServer
 */
class ServiceRequestHandler implements RequestHandlerInterface
{
    /**
     * @var LaminasServer
     */
    private $laminasServer;

    /**
     * @var RequestConverter
     */
    private $requestConverter;

    /**
     * @var ResponseConverter
     */
    private $responseConverter;

    /**
     * ServiceRequestHandler constructor.
     * @param LaminasServer $laminasServer
     * @param RequestConverter $requestConverter
     * @param ResponseConverter $responseConverter
     */
    public function __construct(
        LaminasServer $laminasServer,
        RequestConverter $requestConverter,
        ResponseConverter $responseConverter
    ) {
        $this->laminasServer = $laminasServer;
        $this->requestConverter = $requestConverter;
        $this->responseConverter = $responseConverter;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $laminasRequest = $this->requestConverter->convertToLaminas($request);

        $response = $this->laminasServer->handle($laminasRequest);

        return $this->responseConverter->convertToPsr($response);
    }

    /**
     * @param LaminasServer $laminasServer
     */
    public function setLaminasServer(LaminasServer $laminasServer): void
    {
        $this->laminasServer = $laminasServer;
    }
}

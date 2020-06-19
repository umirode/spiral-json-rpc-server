<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Umirode\JsonRpcServer\Laminas\LaminasServer;

/**
 * Class SmdRequestHandler
 * @package Umirode\JsonRpcServer
 */
class SmdRequestHandler implements RequestHandlerInterface
{
    /**
     * @var LaminasServer
     */
    private $laminasServer;

    /**
     * SmdRequestHandler constructor.
     * @param LaminasServer $laminasServer
     */
    public function __construct(LaminasServer $laminasServer)
    {
        $this->laminasServer = $laminasServer;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($this->laminasServer->getServiceMapArray());
    }
}

<?php


namespace Umirode\JsonRpcServer\Bootloader;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Umirode\JsonRpcServer\Server\Server;

/**
 * Class JsonRpcServerBootloader
 * @package Umirode\JsonRpcServer\Bootloader
 */
class JsonRpcServerBootloader extends Bootloader implements RequestHandlerInterface
{
    protected const SINGLETONS = [
        RequestHandlerInterface::class => self::class,
    ];

    /**
     * @var Server
     */
    private $server;

    /**
     * JsonRpcBootloader constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->server->handle($request);
    }

    /**
     * @param string $service
     * @param string|null $namespace
     */
    public function addService(string $service, ?string $namespace = null): void
    {
        $this->server->addService($service, $namespace);
    }
}

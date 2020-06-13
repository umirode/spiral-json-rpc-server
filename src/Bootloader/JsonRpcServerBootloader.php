<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer\Bootloader;

use Psr\Http\Server\RequestHandlerInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Config\Patch\Append;
use Umirode\JsonRpcServer\Config\JsonRpcServerConfig;
use Umirode\JsonRpcServer\Server;

/**
 * Class JsonRpcServerBootloader
 * @package Umirode\JsonRpcServer\Bootloader
 */
final class JsonRpcServerBootloader extends Bootloader
{
    protected const SINGLETONS = [
        RequestHandlerInterface::class => [self::class, 'jsonRpcServer'],
    ];

    /**
     * @var ConfiguratorInterface
     */
    private $config;

    /**
     * JsonRpcServerBootloader constructor.
     * @param ConfiguratorInterface $config
     */
    public function __construct(ConfiguratorInterface $config)
    {
        $this->config = $config;
    }

    public function boot(): void
    {
        $this->config->setDefaults(
            JsonRpcServerConfig::CONFIG,
            [
                'services' => [],
            ]
        );
    }

    /**
     * @param string $class
     * @param string|null $namespace
     */
    public function addService(string $class, ?string $namespace = null): void
    {
        $this->config->modify(
            JsonRpcServerConfig::CONFIG,
            new Append(
                'services',
                null,
                [
                    'class' => $class,
                    'namespace' => $namespace
                ]
            )
        );
    }

    /**
     * @param JsonRpcServerConfig $config
     * @param Server $server
     * @return Server
     */
    protected function jsonRpcServer(
        JsonRpcServerConfig $config,
        Server $server
    ): Server {
        $services = $config->getServices();

        foreach ($services as $service) {
            $server->addService($service['class'], $service['namespace']);
        }

        return $server;
    }
}

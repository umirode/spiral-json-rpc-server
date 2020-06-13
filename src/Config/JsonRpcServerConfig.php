<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer\Config;

use Spiral\Core\InjectableConfig;

/**
 * Class JsonRpcServerConfig
 * @package Umirode\JsonRpcServer\Config
 */
final class JsonRpcServerConfig extends InjectableConfig
{
    public const CONFIG = 'json_rpc_server';

    protected $config = [
        'services'   => [],
    ];

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->config['services'] ?? [];
    }
}

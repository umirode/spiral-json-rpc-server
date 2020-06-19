<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer;

use Psr\Http\Server\RequestHandlerInterface;

/**
 * Interface ServerInterface
 * @package Umirode\JsonRpcServer
 */
interface ServerInterface extends RequestHandlerInterface
{
    /**
     * @param string $class
     * @param string|null $namespace
     */
    public function addService(string $class, ?string $namespace = null): void;
}

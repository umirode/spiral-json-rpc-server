<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer\Tests\Laminas;

use Laminas\Json\Server\Smd;
use PHPUnit\Framework\TestCase;
use Umirode\JsonRpcServer\Laminas\LaminasServer;

final class LaminasServerTest extends TestCase
{
    public function testCreate(): void
    {
        $server = new LaminasServer();

        $this->assertTrue($server->getReturnResponse());
        $this->assertEquals(Smd::ENV_JSONRPC_2, $server->getEnvelope());
    }

    public function testGetServiceMap(): void
    {
        $server = new LaminasServer();

        $this->assertEquals(
            [
                'transport' => 'POST',
                'envelope' => 'JSON-RPC-2.0',
                'contentType' => 'application/json',
                'SMDVersion' => '2.0',
                'description' => null,
            ],
            $server->getServiceMapArray()
        );
    }
}

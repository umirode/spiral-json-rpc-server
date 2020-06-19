<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer\Laminas;

use Laminas\Json\Server\Server;
use Laminas\Json\Server\Smd;

/**
 * Class LaminasServer
 * @package Umirode\JsonRpcServer\Laminas
 *
 * @method string getEnvelope()
 * @method void setEnvelope(string $envelope)
 */
class LaminasServer extends Server
{
    /**
     * LaminasServer constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setReturnResponse();
        $this->setEnvelope(Smd::ENV_JSONRPC_2);
    }

    /**
     * @inheritDoc
     */
    public function getServiceMapArray(): array
    {
        return $this->getServiceMap()->toArray();
    }
}

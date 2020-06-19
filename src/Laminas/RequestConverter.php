<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer\Laminas;

use Laminas\Json\Json;
use Laminas\Json\Server\Request;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class RequestConverter
 * @package Umirode\JsonRpcServer\Laminas
 */
class RequestConverter
{
    /**
     * @param ServerRequestInterface $request
     * @return Request
     */
    public function convertToLaminas(ServerRequestInterface $request): Request
    {
        $laminasRequest = new Request();
        $laminasRequest->loadJson(Json::encode($request->getParsedBody()));

        return $laminasRequest;
    }
}

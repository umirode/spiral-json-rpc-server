<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer\Laminas;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Json\Json;
use Laminas\Json\Server\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseConverter
 * @package Umirode\JsonRpcServer\Laminas
 */
class ResponseConverter
{
    /**
     * @inheritDoc
     */
    public function convertToPsr(Response $response): ResponseInterface
    {
        return new JsonResponse(Json::decode((string)$response, Json::TYPE_ARRAY));
    }
}

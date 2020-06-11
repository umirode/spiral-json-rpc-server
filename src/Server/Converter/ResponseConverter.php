<?php


namespace Umirode\JsonRpcServer\Server\Converter;


use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Json\Json;
use Laminas\Json\Server\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseConverter
 * @package Umirode\JsonRpcServer\Server\Converter
 */
class ResponseConverter
{
    /**
     * @param Response $response
     * @return ResponseInterface
     */
    public function convert(Response $response): ResponseInterface
    {
        return new JsonResponse(Json::decode((string)$response, Json::TYPE_ARRAY));
    }
}

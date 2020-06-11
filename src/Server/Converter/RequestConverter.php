<?php


namespace Umirode\JsonRpcServer\Server\Converter;


use Laminas\Json\Json;
use Laminas\Json\Server\Request;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class RequestConverter
 * @package Umirode\JsonRpcServer\Server\Converter
 */
class RequestConverter
{
    /**
     * @param ServerRequestInterface $request
     * @return Request
     */
    public function convert(ServerRequestInterface $request): Request
    {
        $jsonRpcRequest = new Request();
        $jsonRpcRequest->loadJson(Json::encode($request->getParsedBody()));

        return $jsonRpcRequest;
    }
}

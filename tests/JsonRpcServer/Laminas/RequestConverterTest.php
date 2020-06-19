<?php


namespace Umirode\JsonRpcServer\Tests\Laminas;


use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\TestCase;
use Umirode\JsonRpcServer\Laminas\RequestConverter;

/**
 * Class RequestConverterTest
 * @package Umirode\JsonRpcServer\Tests\Laminas
 */
final class RequestConverterTest extends TestCase
{
    public function testConvertToLaminas(): void
    {
        $requestConverter = new RequestConverter();

        $data = [
            'jsonrpc' => 2.0,
            'method' => 'test_method',
            'params' => [
                'test1',
                'test2',
                'test3',
            ],
            'id' => 1,
        ];

        $psrRequest = (new ServerRequestFactory())
            ->createServerRequest('POST', '')
            ->withParsedBody($data);

        $laminasRequest = $requestConverter->convertToLaminas($psrRequest);

        $this->assertEquals($data['jsonrpc'], $laminasRequest->getVersion());
        $this->assertEquals($data['method'], $laminasRequest->getMethod());
        $this->assertEquals($data['params'], $laminasRequest->getParams());
        $this->assertEquals($data['id'], $laminasRequest->getId());
    }
}

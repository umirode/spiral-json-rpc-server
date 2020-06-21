<?php

declare(strict_types=1);

namespace Umirode\JsonRpcServer\Tests\Laminas;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Json\Server\Error;
use Laminas\Json\Server\Response;
use PHPUnit\Framework\TestCase;
use Umirode\JsonRpcServer\Laminas\ResponseConverter;

final class ResponseConverterTest extends TestCase
{
    public function testConvertToPsr(): void
    {
        $responseConverter = new ResponseConverter();

        $data = [
            'result' => [
                'test' => 'test',
            ],
            'id' => 1,
        ];

        $laminasResponse = new Response();
        $laminasResponse->setId($data['id']);
        $laminasResponse->setResult($data['result']);

        /** @var JsonResponse $psrResponse */
        $psrResponse = $responseConverter->convertToPsr($laminasResponse);

        $psrResponseData = $psrResponse->getPayload();

        $this->assertEquals($data['id'], $psrResponseData['id']);
        $this->assertEquals($data['result'], $psrResponseData['result']);
    }

    public function testConvertToPsrError(): void
    {
        $responseConverter = new ResponseConverter();

        $data = [
            'error_code' => 123,
            'error_message' => 'test',
            'error_data' => [
                'test' => 'test',
            ],
            'id' => 1,
        ];

        $laminasResponseError = new Error();
        $laminasResponseError->setCode($data['error_code']);
        $laminasResponseError->setMessage($data['error_message']);
        $laminasResponseError->setData($data['error_data']);

        $laminasResponse = new Response();
        $laminasResponse->setId($data['id']);
        $laminasResponse->setError($laminasResponseError);

        /** @var JsonResponse $psrResponse */
        $psrResponse = $responseConverter->convertToPsr($laminasResponse);

        $psrResponseData = $psrResponse->getPayload();
        $this->assertEquals($data['id'], $psrResponseData['id']);
        $this->assertNotEmpty($psrResponseData['error']);

        $psrResponseDataError = $psrResponseData['error'];
        $this->assertEquals($data['error_code'], $psrResponseDataError['code']);
        $this->assertEquals($data['error_message'], $psrResponseDataError['message']);
        $this->assertEquals($data['error_data'], $psrResponseDataError['data']);
    }
}

<?php


namespace Umirode\JsonRpcServer\Server;


use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Json\Server\Server as LaminasServer;
use Laminas\Json\Server\Smd;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Umirode\JsonRpcServer\Server\Converter\RequestConverter;
use Umirode\JsonRpcServer\Server\Converter\ResponseConverter;

/**
 * Class Server
 * @package Umirode\JsonRpcServer\Server
 */
class Server implements RequestHandlerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var RequestConverter
     */
    private $requestConverter;

    /**
     * @var ResponseConverter
     */
    private $responseConverter;

    /**
     * @var LaminasServer
     */
    private $server;

    /**
     * Server constructor.
     * @param ContainerInterface $container
     * @param RequestConverter $requestConverter
     * @param ResponseConverter $responseConverter
     */
    public function __construct(
        ContainerInterface $container,
        RequestConverter $requestConverter,
        ResponseConverter $responseConverter
    ) {
        $this->container = $container;
        $this->requestConverter = $requestConverter;
        $this->responseConverter = $responseConverter;

        $this->server = $this->createServer();
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() === 'GET') {
            return $this->handleDocsRequest($this->server);
        }

        return $this->handleServiceRequest($this->server, $request);
    }

    /**
     * @return LaminasServer
     */
    protected function createServer(): LaminasServer
    {
        $server = new LaminasServer();
        $server->setReturnResponse(true);

        return $server;
    }

    /**
     * @param LaminasServer $server
     * @return JsonResponse
     */
    protected function handleDocsRequest(LaminasServer $server): JsonResponse
    {
        $server->setEnvelope(Smd::ENV_JSONRPC_2);

        return new JsonResponse($server->getServiceMap()->toArray());
    }

    /**
     * @param LaminasServer $server
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    protected function handleServiceRequest(LaminasServer $server, ServerRequestInterface $request): ResponseInterface
    {
        $response = $server->handle($this->requestConverter->convert($request) ?? false);

        return $this->responseConverter->convert($response);
    }

    /**
     * @param string $service
     * @param string|null $namespace
     */
    public function addService(string $service, ?string $namespace = null): void
    {
        $this->server->setClass(
            $this->container->get($service),
            $namespace ?? ''
        );
    }
}

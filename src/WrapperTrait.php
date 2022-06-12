<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Builder\HttpRequestMessageBuilderInterface;
use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;
use Lilith\Http\Parser\ResponseParserInterface;

trait WrapperTrait
{
    public function __construct(
        protected ClientInterface $client,
        protected HttpRequestMessageBuilderInterface $httpRequestMessageBuilder,
        protected ResponseParserInterface $responseParser,
    ) {
        parent::__construct($client);
        $this->completeBaseValues();
    }

    abstract protected function completeBaseValues(): void;
    abstract protected function completeDefaultValues(): void;

    protected function parseResponse(ResponseInterface $response): array
    {
        return $this->responseParser->parse($response);
    }

    protected function request(RequestInterface $request): array
    {
        $this->preRequest($request);
        $response = $this->sendRequest($request);
        $this->postRequest($request, $response);

        return $this->parseResponse($response);
    }

    abstract protected function preRequest(RequestInterface $request): void;
    abstract protected function postRequest(RequestInterface $request, ResponseInterface $response): void;
}

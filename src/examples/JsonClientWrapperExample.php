<?php

declare(strict_types=1);

namespace Lilith\Http\Examples;

use Lilith\Http\ClientInterface;
use Lilith\Http\ClientWrapper;
use Lilith\Http\HttpMethodsEnum;
use Lilith\Http\HttpRequestMessageBuilderInterface;
use Lilith\Http\JsonResponseParser;
use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;

class JsonClientWrapperExample extends ClientWrapper
{
    protected const BASE_URL = 'https://example.com/api';
    protected const DEFAULT_QUERY = ['default' => 'query'];
    protected const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
    ];
    protected const DEFAULT_BODY = ['default' => 'body'];

    public function __construct(
        ClientInterface $client,
        HttpRequestMessageBuilderInterface $httpRequestMessageBuilder,
        JsonResponseParser $responseParser,
    ) {
        parent::__construct($client, $httpRequestMessageBuilder, $responseParser);
    }

    protected function completeBaseValues(): void
    {
        $this->httpRequestMessageBuilder
            ->addUrl(static::BASE_URL)
            ->addQuery(static::DEFAULT_QUERY)
            ->addHeaders(static::DEFAULT_HEADERS)
            ->addBody(static::DEFAULT_BODY)
        ;
    }

    protected function completeDefaultValues(): void
    {
        $this->httpRequestMessageBuilder->addHeaders(['Authorization' => 'Bearer AbCdEf123456']);
    }

    public function addUser(): array
    {
        $this->completeDefaultValues();
        $requestMessage = $this->httpRequestMessageBuilder
            ->addMethod(HttpMethodsEnum::POST)
            ->addUrl('/users')
            ->addBody([
                'email' => 'example@example.com',
                'password' => '12345678',
            ])
            ->create()
        ;

        return $this->request($requestMessage);
    }

    protected function request(RequestInterface $request): array
    {
        $this->preRequest($request);
        $response = $this->sendRequest($request);
        $this->postRequest($request, $response);

        return $this->parseResponse($response);
    }

    protected function preRequest(RequestInterface $request): void
    {
        print $request->getUri();
    }

    protected function postRequest(RequestInterface $request, ResponseInterface $response): void
    {
        print $request->getUri() . $response->getStatusCode();
    }
}

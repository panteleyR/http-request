<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;

class ClientWrapper
{
    protected const BASE_URL = null;
    protected const DEFAULT_HEADERS = [];
    protected const DEFAULT_BODY = null;
    protected const DEFAULT_QUERY = null;

    public function __construct(
        protected ClientInterface $client,
        protected HttpRequestMessageBuilder $httpRequestMessageBuilder,
    ) {
        $this->httpRequestMessageBuilder
            ->addUrl(static::BASE_URL ?? '')
            ->addQuery(static::DEFAULT_QUERY)
            ->addHeaders(static::DEFAULT_HEADERS)
            ->addBody(static::DEFAULT_BODY)
        ;
    }

    final protected function buildRequestMessage(
        HttpMethodsEnum $requestMethod,
        string $requestUrl,
        null|array $requestQuery,
        array $requestHeaders = [],
        null|array $requestBody = null,
        null|array $requestFiles = null,
    ): RequestInterface {
        $this->completeDefaultValues($this->httpRequestMessageBuilder);
        $this->httpRequestMessageBuilder
            ->addMethod($requestMethod)
            ->addUrl($requestUrl)
            ->addQuery($requestQuery)
            ->addHeaders($requestHeaders)
            ->addBody($requestBody)
            ->addFiles($requestFiles)
        ;

        return $this->httpRequestMessageBuilder->createRequestMessage();
    }

    protected function completeDefaultValues(
        HttpRequestMessageBuilder $httpRequestMessageBuilder
    ): void {}

//    final protected function generateRequestMessage(
//        string $requestMethod,
//        string $requestUrl,
//        null|array $requestQuery,
//        array $requestHeaders = [],
//        null|array $requestBody = null,
//    ): RequestInterface {
//        [$defaultQuery, $defaultHeaders, $defaultBody, $baseUrl] = $this->getDefaultValues();
//        $this->completeDefaultValues($defaultQuery, $defaultHeaders, $defaultBody, $baseUrl);
//
//        //mergeData
//        $url = $baseUrl . $requestUrl;
//        $query = ($defaultQuery ?? []) + ($requestQuery ?? []);
//        $headers = $defaultHeaders + $requestHeaders;
//        $body = null;
//
//        if ($requestBody !== null || $defaultBody !== null) {
//            $body = ($requestBody ?? []) + ($defaultBody ?? []);
//        }
//
//        return $this->buildRequestData($requestMethod, $query, $headers, $body, $url);
//    }
//
//    protected function buildRequestData(
//        string $method,
//        array $query,
//        array $headers,
//        null|array $body,
//        string $url,
//    ): RequestInterface {
//        $query = http_build_query($query);
//        $url = $url . ($query === '' ? $query : '?' . $query);
//
//        if ($body !== null) {
//            $body = http_build_query($body);
//        }
//
//        return new Request(HttpMethodsEnum::from($method), $url, $headers, $body);
//    }
//
//    protected function completeDefaultValues(
//        null|array &$defaultQuery,
//        array &$defaultHeaders,
//        null|array &$defaultBody,
//        null|string &$baseUrl,
//    ): void {}
//
//    protected function getDefaultValues(): array
//    {
//        return [
//            static::DEFAULT_QUERY,
//            static::DEFAULT_HEADERS,
//            static::DEFAULT_BODY,
//            static::BASE_URL,
//        ];
//    }

    final public function get(string $url, null|array $query = null, array $headers = []): ResponseInterface
    {
        return $this->request('GET', $url, $query, $headers);
    }

    final public function post(string $url, null|array $query = null, array $headers = [], null|array $body = null): ResponseInterface
    {
        return $this->request('POST', $url, $query, $headers, $body);
    }

    final public function put(string $url, null|array $query = null, array $headers = [], null|array $body = null): ResponseInterface
    {
        return $this->request('PUT', $url, $query, $headers, $body);
    }

    final public function patch(string $url, null|array $query = null, array $headers = [], null|array $body = null): ResponseInterface
    {
        return $this->request('PATCH', $url, $query, $headers, $body);
    }

    final public function delete(string $url, null|array $query = null, array $headers = [], null|array $body = null): ResponseInterface
    {
        return $this->request('DELETE', $url, $query, $headers, $body);
    }

    final public function head(string $url, null|array $query = null, array $headers = []): ResponseInterface
    {
        return $this->request('HEAD', $url, $query, $headers);
    }

    final public function options(string $url, null|array $query = null, array $headers = []): ResponseInterface
    {
        return $this->request('OPTIONS', $url, $query, $headers);
    }

    final public function request(string $method, string $url, null|array $query = null, array $headers = [], null|array $body = null): ResponseInterface
    {
//        $request = $this->generateRequestMessage($method, $url, $query, $headers, $body);
        $request = $this->buildRequestMessage(HttpMethodsEnum::from($method), $url, $query, $headers, $body);
        return $this->sendRequest($request);
    }

    protected function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }
}

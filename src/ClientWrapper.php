<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\Request;
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
    ) {}

    final protected function generateRequestMessage(
        string $requestMethod,
        string $requestUrl,
        null|array $requestQuery,
        array $requestHeaders = [],
        null|array $requestBody = null,
    ): RequestInterface {
        [$defaultQuery, $defaultHeaders, $defaultBody, $baseUrl] = $this->getDefaultValues();
        $this->completeDefaultValues($defaultQuery, $defaultHeaders, $defaultBody, $baseUrl);

        //mergeData
        $url = $baseUrl . $requestUrl;
        $query = ($defaultQuery ?? []) + ($requestQuery ?? []);
        $headers = $defaultHeaders + $requestHeaders;
        $body = null;

        if ($requestBody !== null || $defaultBody !== null) {
            $body = ($requestBody ?? []) + ($defaultBody ?? []);
        }

        return $this->buildRequestData($requestMethod, $query, $headers, $body, $url);
    }

    protected function buildRequestData(
        string $method,
        array $query,
        array $headers,
        null|array $body,
        string $url,
    ): RequestInterface {
        $query = http_build_query($query);
        $url = $url . $query;

        if ($body !== null) {
            $body = http_build_query($body);
        }

        return new Request($method, $url, $headers, $body);
    }

    protected function completeDefaultValues(
        null|array &$defaultQuery,
        array &$defaultHeaders,
        null|array &$defaultBody,
        null|string &$baseUrl,
    ): void {}

    protected function getDefaultValues(): array
    {
        return [
            'defaultQuery' => static::DEFAULT_QUERY,
            'defaultHeaders' => static::DEFAULT_HEADERS,
            'defaultBody' => static::DEFAULT_BODY,
            'baseUrl' => static::BASE_URL,
        ];
    }

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

    final public function request(string $method, string $url, null|array $query = null, array $headers = [], null|array $body = null): ResponseInterface
    {
        $request = $this->generateRequestMessage($method, $url, $query, $headers, $body);
        return $this->sendRequest($request);
    }

    protected function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->request($request);
    }
}

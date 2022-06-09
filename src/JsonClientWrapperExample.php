<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\Request;
use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;

class JsonClientWrapperExample extends ClientWrapper
{
    protected const BASE_URL = 'https://example.com/api';
    protected const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
    ];

    protected function completeDefaultValues(
        null|array &$defaultQuery,
        array &$defaultHeaders,
        null|array &$defaultBody,
        null|string &$baseUrl,
    ): void {
        $defaultHeaders['Authorization'] = 'Bearer AbCdEf123456';
    }

    protected function buildRequestData(
        string $method,
        array $query,
        array $headers,
        null|array $body,
        string $url
    ): RequestInterface {
        $query = http_build_query($query);
        $url = $url . $query;

        if ($body !== null) {
            $body = json_encode($body);
        }

        return new Request($method, $url, $headers, $body);
    }

    protected function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->preRequest($request);
        $response = $this->client->request($request);
        $this->postRequest($request, $response);

        return $response;
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

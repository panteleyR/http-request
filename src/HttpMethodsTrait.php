<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\Request;
use Lilith\Http\Message\ResponseInterface;

trait HttpMethodsTrait
{
    public function get(string $url, array $headers = []): ResponseInterface
    {
        $message = new Request(HttpMethodsEnum::GET, $url, $headers);

        return $this->request($message);
    }

    public function post(string $url, array $headers = [], string $body = ''): ResponseInterface
    {
        $message = new Request(HttpMethodsEnum::POST, $url, $headers, $body);

        return $this->request($message);
    }

    public function put(string $url, array $headers = [], string $body = ''): ResponseInterface
    {
        $message = new Request(HttpMethodsEnum::PUT, $url, $headers, $body);

        return $this->request($message);
    }

    public function patch(string $url, array $headers = [], string $body = ''): ResponseInterface
    {
        $message = new Request(HttpMethodsEnum::PATCH, $url, $headers, $body);

        return $this->request($message);
    }
}

<?php

declare(strict_types=1);

namespace Lilith\Http\Message;

class Request extends Message implements RequestInterface
{
    public function __construct(
        protected readonly string $method,
        protected readonly string $uri,
        array $headers = [],
        null|string $body = null
    ) {
        parent::__construct($headers, $body);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}

<?php

declare(strict_types=1);

namespace Lilith\Http\Message;

class Message implements MessageInterface
{
    public function __construct(
        protected readonly array $headers = [],
        protected readonly null|string $body = null,
    ) {}

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name): string
    {
        return $this->headers[$name];
    }

    public function getBody(): null|string
    {
        return $this->body;
    }
}

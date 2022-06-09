<?php

declare(strict_types=1);

namespace Lilith\Http\Message;

class Response extends Message implements ResponseInterface
{
    public function __construct(
        protected readonly int $statusCode,
        array $headers = [],
        null|string $body = null
    ) {
        parent::__construct($headers, $body);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}

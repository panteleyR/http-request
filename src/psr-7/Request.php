<?php

declare(strict_types=1);

namespace Lilith\Http\PSR7;

use Lilith\Http\PSR7\Interfaces\RequestInterface;
use Lilith\Http\PSR7\Interfaces\UriInterface;

class Request extends Message implements RequestInterface
{
    private string $requestTarget = '/';
    private string $method;
    private UriInterface $uri;

    public function getRequestTarget(): string
    {
        return $this->requestTarget;
    }

    public function withRequestTarget(mixed $requestTarget): static
    {
        $this->requestTarget = (string) $requestTarget;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function withMethod(string $method): static
    {
        $this->method = $method;

        return $this;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function withUri(UriInterface $uri, bool $preserveHost = false): static
    {
        $this->uri = $uri;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\Request;
use Lilith\Http\Message\RequestInterface;

class HttpRequestMessageBuilder
{
    protected null|array $body = null;
    protected null|array $files = null;
    protected array $headers = [];
    protected array $query = [];
    protected string $url;
    protected HttpMethodsEnum $method;
    protected string $protocolVersion = '1.1';

    public function __construct(
        null|string $url,
        array $query = [],
        array $headers = [],
        null|array $body = null,
        string $protocolVersion = '1.1',
    ) {
        $this->url = $url ?? '';
        $this->body = $body;
        $this->query = $query;
        $this->headers = $headers;
        $this->protocolVersion = $protocolVersion;
    }

    public function addHeaders(array $headers): static
    {
        $this->headers = $this->headers + $headers;

        return $this;
    }

    public function addBody(array $body): static
    {
        $this->body = $this->body + $body;

        return $this;
    }

    public function addFiles(array $files): static
    {
        $this->files = $this->files + $files;

        return $this;
    }

    public function addQuery(array $query): static
    {
        $this->query = $this->query + $query;

        return $this;
    }

    public function addUrl(string $url): static
    {
        $this->url = $this->url . $url;

        return $this;
    }

    public function addMethod(HttpMethodsEnum $method): static
    {
        $this->method = $method;

        return $this;
    }

    public function createRequestMessage(): RequestInterface
    {
        $method = $this->method;
        $query = http_build_query($this->query);
        $url = $this->url . ($query === '' ? $query : '?' . $query);
        $body = null;

        if ($this->body !== null) {
            $body = http_build_query($this->body);
        }

        if ($this->files !== null) {
            //@TODO multiple/form-data
        }

        return new Request($method, $url, $this->headers, $body, $this->protocolVersion);
    }
}

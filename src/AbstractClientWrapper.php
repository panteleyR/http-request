<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;

abstract class AbstractClientWrapper
{
    public function __construct(
        private readonly ClientInterface $client,
    ) {}

    abstract protected function completeBaseValues(): void;
    abstract protected function completeDefaultValues(): void;

    final protected function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }
}

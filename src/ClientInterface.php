<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;

interface ClientInterface
{
//    public function request(RequestInterface $request): ResponseInterface;
    public function sendRequest(RequestInterface $request): ResponseInterface;
}

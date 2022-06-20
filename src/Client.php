<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;
use Lilith\Http\RequestSender\RequestSenderInterface;
use Lilith\Http\RequestSender\RequestSender;

class Client implements ClientInterface
{
    use HttpMethodsTrait;

    public function __construct(protected RequestSenderInterface $requestSender = new RequestSender()) {}

    final public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->requestSender->send($request);
    }
}

<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    use HttpMethodsTrait;

    public function __construct(protected RequestSenderInterface $requestSender = new RequestSender()) {}

    final public function request(RequestInterface $request): ResponseInterface
    {
        return $this->requestSender->send($request);
    }
}

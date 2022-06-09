<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    use HttpMethodsTrait;

    public function __construct(protected RequestServiceInterface $requestService = new RequestService()) {}

    final public function request(RequestInterface $request): ResponseInterface
    {
        return $this->requestService->request($request);
    }
}

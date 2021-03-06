<?php

declare(strict_types=1);

namespace Lilith\Http;

use Lilith\Http\Builder\HttpRequestMessageBuilderInterface;
use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;
use Lilith\Http\Parser\ResponseParserInterface;

class ClientWrapper extends AbstractClientWrapper
{
    protected const BASE_URL = null;
    protected const DEFAULT_QUERY = null;
    protected const DEFAULT_HEADERS = null;
    protected const DEFAULT_BODY = null;

    public function __construct(
        ClientInterface $client,
        protected HttpRequestMessageBuilderInterface $httpRequestMessageBuilder,
        protected ResponseParserInterface $responseParser,
    ) {
        parent::__construct($client);
        $this->completeBaseValues();
    }

    protected function completeBaseValues(): void {}
    protected function completeDefaultValues(): void {}

    //@TODO Сделать связывание дефолт параметров под билдер для авторизации через коллбеки
    protected function request(RequestInterface $request): array
    {
        $response = $this->sendRequest($request);

        return $this->parseResponse($response);
    }

    protected function parseResponse(ResponseInterface $response): array
    {
        return $this->responseParser->parse($response);
    }
}

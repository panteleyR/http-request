<?php

declare(strict_types=1);

namespace Lilith\Http\Parser;

use Lilith\Http\Message\ResponseInterface;

class HttpResponseParser implements ResponseParserInterface
{
    public function parse(ResponseInterface $response): array
    {
        parse_str($response->getBody(), $responseList);

        return $responseList;
    }
}

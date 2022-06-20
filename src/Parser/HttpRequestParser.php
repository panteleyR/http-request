<?php

declare(strict_types=1);

namespace Lilith\Http\Parser;

use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\Uri;
use Lilith\Http\Message\UriInterface;

class HttpRequestParser implements RequestParserInterface
{
    public static function parseBody(RequestInterface $request): array
    {
        parse_str($request->getBody(), $requestBody);

        return $requestBody;
    }

    public static function parseUri(RequestInterface $request): UriInterface
    {
        return new Uri($request->getUri());
    }
}

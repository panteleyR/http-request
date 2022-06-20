<?php

declare(strict_types=1);

namespace Lilith\Http\Parser;

use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\UriInterface;

interface RequestParserInterface
{
    public static function parseBody(RequestInterface $request): mixed;
    public static function parseUri(RequestInterface $request): UriInterface;
}

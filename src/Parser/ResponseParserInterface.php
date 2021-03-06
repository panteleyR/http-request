<?php

declare(strict_types=1);

namespace Lilith\Http\Parser;

use Lilith\Http\Message\ResponseInterface;

interface ResponseParserInterface
{
    public static function parseBody(ResponseInterface $response): mixed;
}

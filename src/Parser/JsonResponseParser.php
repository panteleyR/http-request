<?php

declare(strict_types=1);

namespace Lilith\Http\Parser;

use JsonException;
use Lilith\Http\Message\ResponseInterface;

use function Lilith\Common\Functions\json_decode;

class JsonResponseParser implements ResponseParserInterface
{
    /**
     * @throws JsonException
     */
    public static function parseBody(ResponseInterface $response): array
    {
        return json_decode($response->getBody(),true);
    }
}

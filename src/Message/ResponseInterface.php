<?php

declare(strict_types=1);

namespace Lilith\Http\Message;

interface ResponseInterface extends MessageInterface
{
    public function getStatusCode(): int;
}

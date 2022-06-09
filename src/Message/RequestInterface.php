<?php

declare(strict_types=1);

namespace Lilith\Http\Message;

interface RequestInterface extends MessageInterface
{
    public function getUri(): string;
    public function getMethod(): string;
}

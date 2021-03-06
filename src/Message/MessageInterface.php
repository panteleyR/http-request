<?php

declare(strict_types=1);

namespace Lilith\Http\Message;

interface MessageInterface
{
    public function getHeaders(): array;
    public function getHeader(string $name): string;
    public function getBody(): null|string;
    public function getProtocolVersion(): string;
}

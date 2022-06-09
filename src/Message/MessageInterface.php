<?php

declare(strict_types=1);

namespace Lilith\Http\Message;

interface MessageInterface
{
    public function getHeaders(): array;
    public function getHeader(string $name): string;
    public function getBody(): null|string;
//    public function setHeaders(array $value): string;
//    public function setHeader(string $name, string $value): string;
//    public function setBody(): string;
}

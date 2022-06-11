<?php

declare(strict_types=1);

namespace Lilith\Http\Message;

use Lilith\Http\HttpMethodsEnum;

interface RequestInterface extends MessageInterface
{
    public function getUri(): string;
    public function getMethod(): HttpMethodsEnum;
}

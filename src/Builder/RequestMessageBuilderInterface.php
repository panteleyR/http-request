<?php

declare(strict_types=1);

namespace Lilith\Http\Builder;

use Lilith\Http\Message\RequestInterface;

interface RequestMessageBuilderInterface
{
    public function create(): RequestInterface;
    public function clear(): void;
}

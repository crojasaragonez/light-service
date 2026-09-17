<?php

declare(strict_types=1);

namespace crojasaragonez\LightService\Attributes;

/**
 * Base for the attributes that declare which context keys an action deals with.
 */
abstract readonly class ContextKeys
{
    /** @var array<string> */
    public array $keys;

    public function __construct(string ...$keys)
    {
        $this->keys = $keys;
    }
}

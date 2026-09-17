<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use crojasaragonez\LightService\Attributes\Expects;
use crojasaragonez\LightService\Attributes\Promises;

abstract class Action
{
    /** @var array<string> */
    public array $expects = [];

    /** @var array<string> */
    public array $promises = [];

    public array $context;

    public function __construct(array &$context = [])
    {
        $this->context = &$context;
        $this->expects = AttributeResolver::merge(
            AttributeResolver::keysFor($this, Expects::class),
            $this->expects
        );
        $this->promises = AttributeResolver::merge(
            AttributeResolver::keysFor($this, Promises::class),
            $this->promises
        );
    }

    abstract public function execute(): void;

    public function skipRemaining(): void
    {
        $this->context['skip_remaining'] = true;
    }
}

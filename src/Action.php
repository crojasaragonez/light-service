<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

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
    }

    abstract public function execute(): void;

    public function skipRemaining(): void
    {
        $this->context['skip_remaining'] = true;
    }
}

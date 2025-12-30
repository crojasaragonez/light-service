<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class SkipInvalidAction extends Action
{
    /** @var array<string> */
    public array $promises = ['bar'];

    public function execute(): void
    {
        $this->skipRemaining();
    }
}

<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class ActionWithReservedKey extends Action
{
    /** @var array<string> */
    public array $promises = ['skip_remaining'];

    public function execute(): void
    {
    }
}

<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class ActionWithReservedKey extends Action
{
    public $promises  = ['skip_remaining'];
    public function execute(): ?array
    {
        return $this->context;
    }
}

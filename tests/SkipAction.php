<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class SkipAction extends Action
{
    public function execute(): void
    {
        $this->skipRemaining();
    }
}

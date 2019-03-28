<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class SkipInvalidAction extends Action
{
    public $promises = ['bar'];
    public function execute()
    {
        $this->skipRemaining();
    }
}

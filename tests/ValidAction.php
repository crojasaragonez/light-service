<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class ValidAction extends Action
{
    public $expects  = ['foo'];
    public $promises = ['bar'];
    public function execute(): ?array
    {
        $this->context['bar'] = 1;
        return $this->context;
    }
}

<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class InvalidAction extends Action
{
    public $promises = ['bar'];
    public function execute(): ?array
    {
        return $this->context;
    }
}

<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

abstract class Action
{
    public $expects = [];
    public $promises = [];
    abstract public function execute($context);
}

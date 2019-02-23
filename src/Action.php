<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

abstract class Action
{
    public $expects = [];
    public $promises = [];
    public $context = [];
    public function __construct(array $context = [])
    {
        $this->context = $context;
    }
    abstract public function execute(): ?array;
    public function skipRemaining()
    {
        $this->context['skip_remaining'] = true;
    }
}

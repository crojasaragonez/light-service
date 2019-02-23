<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

abstract class Action
{
    protected $expects;
    protected $promises;
    /**
     * Create a new Action Instance
     */
    public function __construct()
    {
        // constructor body
    }

    abstract public function execute($context);
}

<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

abstract class Organizer
{
    protected $context;
    /**
     * Create a new Organizer Instance
     */
    public function __construct()
    {
        $this->context = [];
    }
}

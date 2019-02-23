<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use Exception;

abstract class Organizer
{
    protected $context;
    /**
     * Create a new Organizer Instance
     */
    public function __construct($context = [])
    {
        $this->context = $context;
    }

    public function reduce($actions = [])
    {
        foreach ($actions as $action) {
            $instance = new $action();
            $this->checkExpectations($instance);
            $this->context = $instance->execute($this->context);
            $this->checkPromises($instance);
        }
    }

    private function checkExpectations(Action $instance)
    {
        foreach ($instance->expects as $key) {
            $this->failIfEmpty($key, "Expected key $key was not found in context");
        }
    }

    private function checkPromises(Action $instance)
    {
        foreach ($instance->promises as $key) {
            $this->failIfEmpty($key, "Action class promised to set the $key value but did not do it.");
        }
    }

    public function failIfEmpty($key, $errorMessage)
    {
        if (!isset($this->context[$key])) {
            throw new Exception($errorMessage, 1);
        }
    }
}

<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

/**
 * Abstract base class for all service actions.
 *
 * This class provides the foundation for implementing service actions with
 * context management and execution flow control.
 */
abstract class Action
{
    /**
     * @var array<string> Array of expected context keys
     */
    public array $expects = [];

    /**
     * @var array<string> Array of promised context keys
     */
    public array $promises = [];

    /**
     * @var array<mixed> Reference to the context array
     */
    public array $context;

    /**
     * Constructor for Action class.
     *
     * @param array<mixed> $context Reference to the context array
     */
    public function __construct(array &$context = [])
    {
        $this->context = &$context;
    }

    /**
     * Execute the action's main logic.
     * Must be implemented by concrete action classes.
     *
     * @return void
     */
    abstract public function execute(): void;

    /**
     * Skip remaining actions in the organizer.
     *
     * @return void
     */
    public function skipRemaining(): void
    {
        $this->context['skip_remaining'] = true;
    }
}

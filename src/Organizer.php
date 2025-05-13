<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

/**
 * Organizer class for managing and executing service actions.
 *
 * This class is responsible for orchestrating the execution of multiple actions
 * in sequence, handling context management and validation.
 */
class Organizer
{
    public const SKIP_REMAINING = 'skip_remaining';
    public const RESERVED_KEYS  = [self::SKIP_REMAINING];

    /**
     * @var array<mixed> The context array shared between actions
     */
    public array $context;

    /**
     * Constructor for Organizer class.
     *
     * @param array<mixed> $context Initial context array
     */
    public function __construct(array $context = [])
    {
        $this->context = $context;
    }

    /**
     * Execute a sequence of actions and return the final context.
     *
     * @param array<string> $actions Array of action class names to execute
     * @return array<mixed>|null The final context after all actions are executed
     * @throws \InvalidArgumentException If an action class doesn't exist
     */
    public function reduce(array $actions = []): ?array
    {
        foreach ($actions as $action) {
            if (!class_exists($action)) {
                throw new \InvalidArgumentException("Action class '$action' does not exist");
            }

            if ($this->context[self::SKIP_REMAINING] ?? false) {
                continue;
            }

            $instance = new $action($this->context);
            if (!$instance instanceof Action) {
                throw new \InvalidArgumentException("Class '$action' must extend Action");
            }

            PreProcessor::validate($this, $instance);
            $instance->execute();
            PostProcessor::validate($this, $instance);
        }

        return ContextHelper::removeReservedKeys(self::RESERVED_KEYS, $this->context);
    }
}

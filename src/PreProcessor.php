<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

/**
 * Exception thrown when expected context keys are missing.
 */
class MissingContextKeysException extends \Exception {}

/**
 * Exception thrown when reserved keys are used in action context.
 */
class ReservedKeysException extends \Exception {}

/**
 * PreProcessor class for validating actions before execution.
 *
 * This class handles validation of action expectations and context keys
 * before an action is executed.
 */
class PreProcessor
{
    private Organizer $organizer;
    private Action $action;

    /**
     * Constructor for PreProcessor.
     *
     * @param Organizer $organizer The organizer instance
     * @param Action $action The action to validate
     */
    public function __construct(Organizer $organizer, Action $action)
    {
        $this->organizer = $organizer;
        $this->action = $action;
    }

    /**
     * Validate an action's expectations and context keys.
     *
     * @param Organizer $organizer The organizer instance
     * @param Action $action The action to validate
     * @throws MissingContextKeysException When expected keys are missing
     * @throws ReservedKeysException When reserved keys are used
     */
    public static function validate(Organizer $organizer, Action $action): void
    {
        $instance = new self($organizer, $action);
        $instance->checkExpectations();
        $instance->checkReservedKeys();
    }

    /**
     * Check if all expected context keys are present.
     *
     * @throws MissingContextKeysException When expected keys are missing
     */
    private function checkExpectations(): void
    {
        $missing_keys = ContextHelper::missingKeys($this->action->expects, $this->organizer->context);
        if ($missing_keys) {
            throw new MissingContextKeysException(
                "Expected keys '$missing_keys' to be in the context during " . get_class($this->action)
            );
        }
    }

    /**
     * Check if any reserved keys are being used.
     *
     * @throws ReservedKeysException When reserved keys are used
     */
    private function checkReservedKeys(): void
    {
        $action_keys = array_merge($this->action->expects, $this->action->promises);
        $reserved_keys_in_use = ContextHelper::forbiddenKeys(Organizer::RESERVED_KEYS, $action_keys);
        if ($reserved_keys_in_use) {
            throw new ReservedKeysException(
                "Promised or expected keys cannot be a reserved key ('$reserved_keys_in_use')"
            );
        }
    }
}

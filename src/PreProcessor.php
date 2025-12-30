<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use Exception;

final readonly class PreProcessor
{
    public function __construct(
        private Organizer $organizer,
        private Action $action,
    ) {
    }

    public static function validate(Organizer $organizer, Action $action): void
    {
        $instance = new self($organizer, $action);
        $instance->checkExpectations();
        $instance->checkReservedKeys();
    }

    private function checkExpectations(): void
    {
        $missing_keys = ContextHelper::missingKeys($this->action->expects, $this->organizer->context);
        if ($missing_keys) {
            throw new Exception("expected '$missing_keys' to be in the context during " . $this->action::class);
        }
    }

    private function checkReservedKeys(): void
    {
        $action_keys = array_merge($this->action->expects, $this->action->promises);
        $reserved_keys_in_use = ContextHelper::forbiddenKeys(Organizer::RESERVED_KEYS, $action_keys);
        if ($reserved_keys_in_use) {
            throw new Exception("promised or expected keys cannot be a reserved key ('$reserved_keys_in_use')");
        }
    }
}

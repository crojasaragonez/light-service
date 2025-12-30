<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use Exception;

final readonly class PostProcessor
{
    public function __construct(
        private Organizer $organizer,
        private Action $action,
    ) {
    }

    public static function validate(Organizer $organizer, Action $action): void
    {
        $instance = new self($organizer, $action);
        if ($action->context[Organizer::SKIP_REMAINING] ?? false) {
            return;
        }
        $instance->checkPromises();
    }

    private function checkPromises(): void
    {
        $missing_keys = ContextHelper::missingKeys($this->action->promises, $this->organizer->context);
        if ($missing_keys) {
            throw new Exception("promised '$missing_keys' to be in the context during " . $this->action::class);
        }
    }
}

<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class PostProcessor
{
    private $organizer;
    private $action;
    public function __construct(Organizer $organizer, Action $action)
    {
        $this->organizer = $organizer;
        $this->action    = $action;
    }

    public static function validate(Organizer $organizer, Action $action)
    {
        $instance = new self($organizer, $action);
        if ($action->context[Organizer::SKIP_REMAINING] ?? false) {
            return;
        }
        $instance->checkPromises();
    }

    private function checkPromises()
    {
        $missing_keys = ContextHelper::missingKeys($this->action->promises, $this->organizer->context);
        if ($missing_keys) {
            throw new \Exception("promised '$missing_keys' to be in the context during " . get_class($this->action));
        }
    }
}

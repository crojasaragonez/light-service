<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class PreProcessor
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
        $instance->checkExpectations();
        $instance->checkReservedKeys();
    }

    private function checkExpectations()
    {
        $missing_keys = ContextHelper::missingKeys($this->action->expects, $this->organizer->context);
        if ($missing_keys) {
            throw new \Exception("expected '$missing_keys' to be in the context during " . get_class($this->action));
        }
    }

    private function checkReservedKeys()
    {
        $action_keys = array_merge($this->action->expects, $this->action->promises);
        $reserved_keys_in_use = ContextHelper::forbiddenKeys(Organizer::RESERVED_KEYS, $action_keys);
        if ($reserved_keys_in_use) {
            throw new \Exception("promised or expected keys cannot be a reserved key ('$reserved_keys_in_use')");
        }
    }
}

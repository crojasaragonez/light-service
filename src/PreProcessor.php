<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use Exception;

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
        foreach ($this->action->expects as $key) {
            if (!isset($this->organizer->context[$key])) {
                throw new Exception("expected '$key' to be in the context during " . get_class($this->action), 1);
            }
        }
    }

    private function checkReservedKeys()
    {
        $actual_keys = array_merge($this->action->expects, $this->action->promises);
        foreach ($actual_keys as $key) {
            if (in_array($key, Organizer::RESERVED_KEYS)) {
                throw new Exception("promised or expected keys cannot be a reserved key ('$key')", 1);
            }
        }
    }
}

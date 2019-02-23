<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use Exception;

abstract class Organizer
{
    const SKIP_REMAINING = 'skip_remaining';
    const RESERVED_KEYS  = [self::SKIP_REMAINING];

    protected $context;

    public function __construct(array $context = [])
    {
        $this->context = $context;
    }

    public function reduce($actions = []) : ?array
    {
        foreach ($actions as $action) {
            if ($this->context[self::SKIP_REMAINING] ?? false) {
                continue;
            }
            $instance = new $action($this->context);
            $this->checkExpectations($instance);
            $this->checkReservedKeys($instance);
            $this->context = $instance->execute();
            $this->checkPromises($instance);
        }
        $this->clearReservedKeys();
        return $this->context;
    }

    private function clearReservedKeys()
    {
        foreach (self::RESERVED_KEYS as $reserved_key) {
            unset($this->context[$reserved_key]);
        }
    }

    private function checkReservedKeys(Action $instance)
    {
        $actual_keys = array_merge($instance->expects, $instance->promises);
        foreach ($actual_keys as $key) {
            if (in_array($key, self::RESERVED_KEYS)) {
                throw new Exception("promised or expected keys cannot be a reserved key ('$key')", 1);
            }
        }
    }

    private function checkExpectations(Action $instance)
    {
        foreach ($instance->expects as $key) {
            $this->failIfEmpty($key, "expected '$key' to be in the context during " . get_class($instance));
        }
    }

    private function checkPromises(Action $instance)
    {
        foreach ($instance->promises as $key) {
            $this->failIfEmpty($key, "promised '$key' to be in the context during " . get_class($instance));
        }
    }

    public function failIfEmpty($key, $errorMessage)
    {
        if (!isset($this->context[$key])) {
            throw new Exception($errorMessage, 1);
        }
    }
}

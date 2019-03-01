<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

abstract class Organizer
{
    const SKIP_REMAINING = 'skip_remaining';
    const RESERVED_KEYS  = [self::SKIP_REMAINING];

    public $context;
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
            PreProcessor::validate($this, $instance);
            $instance->execute();
            PostProcessor::validate($this, $instance);
        }
        return ContextHelper::removeReservedKeys(Organizer::RESERVED_KEYS, $this->context);
    }
}

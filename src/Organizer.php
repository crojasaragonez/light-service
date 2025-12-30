<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class Organizer
{
    final public const string SKIP_REMAINING = 'skip_remaining';

    /** @var array<string> */
    final public const array RESERVED_KEYS = [self::SKIP_REMAINING];

    /** @var array<string, mixed> */
    public array $context;

    /**
     * @param array<string, mixed> $context
     */
    public function __construct(array $context = [])
    {
        $this->context = $context;
    }

    /**
     * @param array<class-string<Action>> $actions
     * @return array<string, mixed>|null
     */
    public function reduce(array $actions = []): ?array
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
        return ContextHelper::removeReservedKeys(self::RESERVED_KEYS, $this->context);
    }
}

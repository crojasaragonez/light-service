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
     * @param callable(int $current, int $total, class-string<Action> $action, bool $skipped): void|null $onProgress
     * @return array<string, mixed>|null
     */
    public function reduce(array $actions = [], ?callable $onProgress = null): ?array
    {
        $total = count($actions);
        $current = 0;

        foreach ($actions as $action) {
            $skipped = $this->context[self::SKIP_REMAINING] ?? false;

            if (!$skipped) {
                $instance = new $action($this->context);
                PreProcessor::validate($this, $instance);
                $instance->execute();
                PostProcessor::validate($this, $instance);
            }

            $current++;
            if ($onProgress !== null) {
                $onProgress($current, $total, $action, $skipped);
            }
        }
        return ContextHelper::removeReservedKeys(self::RESERVED_KEYS, $this->context);
    }
}

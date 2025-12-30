<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

final class ContextHelper
{
    /**
     * @param array<string> $expected_keys
     * @param array<string, mixed> $context
     */
    public static function missingKeys(array $expected_keys, array $context): string
    {
        $diff = array_diff($expected_keys, array_keys($context));
        return implode(', ', array_values($diff));
    }

    /**
     * @param array<string> $forbidden_keys
     * @param array<string> $current_keys
     */
    public static function forbiddenKeys(array $forbidden_keys, array $current_keys): string
    {
        $diff = array_intersect($forbidden_keys, $current_keys);
        return implode(', ', array_values($diff));
    }

    /**
     * @param array<string> $reserved_keys
     * @param array<string, mixed> $context
     * @return array<string, mixed>
     */
    public static function removeReservedKeys(array $reserved_keys, array $context): array
    {
        return array_diff_key($context, array_flip($reserved_keys));
    }
}

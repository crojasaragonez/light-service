<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class ContextHelper
{
    public static function missingKeys(array $expected_keys, array $context)
    {
        $diff = array_diff($expected_keys, array_keys($context));
        return join(array_values($diff), ', ');
    }

    public static function forbiddenKeys(array $forbidden_keys, array $current_keys)
    {
        $diff = array_intersect($forbidden_keys, $current_keys);
        return join(array_values($diff), ', ');
    }

    public static function removeReservedKeys(array $reserved_keys, array $context)
    {
        return array_diff_key($context, array_flip($reserved_keys));
    }
}

<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use crojasaragonez\LightService\Attributes\ContextKeys;
use ReflectionClass;

final class AttributeResolver
{
    /** @var array<class-string, array<class-string<ContextKeys>, array<string>>> */
    private static array $cache = [];

    /**
     * Collects the keys declared by every $attribute on $target and its ancestors.
     *
     * Parent declarations come first, so a base action's keys keep their position.
     *
     * @param class-string<ContextKeys> $attribute
     * @return array<string>
     */
    public static function keysFor(object|string $target, string $attribute): array
    {
        $class = is_object($target) ? $target::class : $target;

        if (isset(self::$cache[$class][$attribute])) {
            return self::$cache[$class][$attribute];
        }

        $keys = [];
        foreach (array_reverse(self::hierarchyOf($class)) as $reflection) {
            foreach ($reflection->getAttributes($attribute) as $declaration) {
                $keys = array_merge($keys, $declaration->newInstance()->keys);
            }
        }

        return self::$cache[$class][$attribute] = $keys;
    }

    /**
     * Merges attribute declared keys with the ones declared as a property, without duplicates.
     *
     * An action that declares no attributes keeps its property untouched.
     *
     * @param array<string> $from_attributes
     * @param array<string> $from_property
     * @return array<string>
     */
    public static function merge(array $from_attributes, array $from_property): array
    {
        if ($from_attributes === []) {
            return $from_property;
        }
        return array_values(array_unique(array_merge($from_attributes, $from_property)));
    }

    /**
     * @param class-string $class
     * @return array<ReflectionClass<object>>
     */
    private static function hierarchyOf(string $class): array
    {
        $hierarchy = [];
        $reflection = new ReflectionClass($class);
        while ($reflection !== false) {
            $hierarchy[] = $reflection;
            $reflection = $reflection->getParentClass();
        }
        return $hierarchy;
    }
}

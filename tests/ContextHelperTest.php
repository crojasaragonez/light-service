<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use PHPUnit\Framework\TestCase;

class ContextHelperTest extends TestCase
{
    /**
     * Test that missingKeys returns the right value when all expected keys are present
     */
    public function testMissingKeysWhenAllExpectedKeysArePresent(): void
    {
        $expected = ['a', 'b', 'c'];
        $context = ['a' => 1, 'b' => 2, 'c' => 3];
        $missing_keys = ContextHelper::missingKeys($expected, $context);
        $this->assertEquals($missing_keys, '');
    }

    /**
     * Test that missingKeys returns the right value when all expected keys are missing
     */
    public function testMissingKeysWhenAllExpectedKeysAreMissing(): void
    {
        $expected = ['a', 'b', 'c'];
        $context = [];
        $missing_keys = ContextHelper::missingKeys($expected, $context);
        $this->assertEquals($missing_keys, 'a, b, c');
    }

    /**
     * Test that missingKeys returns the right value when some expected keys are missing
     */
    public function testMissingKeysWhenSomeExpectedKeysAreMissing(): void
    {
        $expected = ['a', 'b', 'c'];
        $context = ['c' => 3];
        $missing_keys = ContextHelper::missingKeys($expected, $context);
        $this->assertEquals($missing_keys, 'a, b');
    }

    /**
     * Test that forbiddenKeys returns the right value when no forbidden keys are present
     */
    public function testForbiddenKeysWhenNoForbiddenKeysArePresent(): void
    {
        $reserved_keys = ['a', 'b', 'c'];
        $current_keys = ['d'];
        $forbidden_keys = ContextHelper::forbiddenKeys($reserved_keys, $current_keys);
        $this->assertEquals($forbidden_keys, '');
    }

    /**
     * Test that forbiddenKeys returns the right value when all forbidden keys are present
     */
    public function testForbiddenKeysWhenAllForbiddenKeysArePresent(): void
    {
        $reserved_keys = ['a', 'b', 'c'];
        $current_keys = ['c', 'b', 'a'];
        $forbidden_keys = ContextHelper::forbiddenKeys($reserved_keys, $current_keys);
        $this->assertEquals($forbidden_keys, 'a, b, c');
    }

    /**
     * Test that forbiddenKeys returns the right value when some forbidden keys are present
     */
    public function testForbiddenKeysWhenSomeForbiddenKeysArePresent(): void
    {
        $reserved_keys = ['a', 'b', 'c'];
        $current_keys = ['b'];
        $forbidden_keys = ContextHelper::forbiddenKeys($reserved_keys, $current_keys);
        $this->assertEquals($forbidden_keys, 'b');
    }

    /**
     * Test that removeReservedKeys removes the desired keys from the context when present
     */
    public function testRemoveReservedKeysWhenReservedKeysArePresent(): void
    {
        $reserved_keys = ['a', 'b', 'c'];
        $context = ['c' => 3];
        $result = ContextHelper::removeReservedKeys($reserved_keys, $context);
        $this->assertEquals($result, []);
    }

    /**
     * Test that removeReservedKeys does nothing when no reserved keys are present in the context
     */
    public function testRemoveReservedKeysWhenReservedKeysAreNotPresent(): void
    {
        $reserved_keys = ['a', 'b', 'c'];
        $context = ['d' => 3];
        $result = ContextHelper::removeReservedKeys($reserved_keys, $context);
        $this->assertEquals($result, ['d' => 3]);
    }
}

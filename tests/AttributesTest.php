<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use crojasaragonez\LightService\Attributes\Expects;
use crojasaragonez\LightService\Attributes\Promises;
use Exception;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    /**
     * Test that attributes populate the expects and promises properties
     */
    public function testAttributesPopulateKeys(): void
    {
        $action = new AttributedAction();
        $this->assertEquals(['foo'], $action->expects);
        $this->assertEquals(['bar'], $action->promises);
    }

    /**
     * Test that an attribute can declare several keys and be repeated
     */
    public function testAttributesAcceptSeveralKeysAndRepetition(): void
    {
        $action = new MultiKeyAttributedAction();
        $this->assertEquals(['foo', 'baz', 'qux'], $action->expects);
        $this->assertEquals(['bar'], $action->promises);
    }

    /**
     * Test that attributes and properties can be combined without duplicating keys
     */
    public function testAttributesAreMergedWithProperties(): void
    {
        $action = new CombinedAction();
        $this->assertEquals(['foo', 'baz'], $action->expects);
        $this->assertEquals(['bar', 'qux'], $action->promises);
    }

    /**
     * Test that attributes declared on a parent action are inherited
     */
    public function testAttributesAreInheritedFromParentActions(): void
    {
        $action = new InheritedAttributedAction();
        $this->assertEquals(['foo', 'baz'], $action->expects);
        $this->assertEquals(['bar'], $action->promises);
    }

    /**
     * Test that actions without attributes keep their property values
     */
    public function testActionsWithoutAttributesAreUntouched(): void
    {
        $action = new ValidAction();
        $this->assertEquals(['foo'], $action->expects);
        $this->assertEquals(['bar'], $action->promises);
    }

    /**
     * Test that an action declaring no attributes keeps its property arrays exactly as written
     */
    public function testActionsWithoutAttributesKeepTheirPropertyArraysVerbatim(): void
    {
        $action = new DuplicateKeysAction();
        $this->assertEquals(['foo', 'foo'], $action->expects);
    }

    /**
     * Test that the resolver reads the keys straight from a class name
     */
    public function testResolverReadsKeysFromAClassName(): void
    {
        $this->assertEquals(['foo'], AttributeResolver::keysFor(AttributedAction::class, Expects::class));
        $this->assertEquals(['bar'], AttributeResolver::keysFor(AttributedAction::class, Promises::class));
        $this->assertEquals([], AttributeResolver::keysFor(ValidAction::class, Expects::class));
    }

    /**
     * Test that the organizer honours expectations and promises declared as attributes
     */
    public function testOrganizerRunsAttributedActions(): void
    {
        $organizer = new Organizer(['foo' => 1]);
        $this->assertEquals(['foo' => 1, 'bar' => 1], $organizer->reduce([AttributedAction::class]));
    }

    /**
     * Test that the organizer raises an error when an expectation declared as an attribute is missing
     */
    public function testOrganizerRaisesOnMissingAttributedExpectations(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("expected 'foo' to be in the context");
        (new Organizer())->reduce([AttributedAction::class]);
    }

    /**
     * Test that the organizer raises an error when a promise declared as an attribute is broken
     */
    public function testOrganizerRaisesOnBrokenAttributedPromises(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("promised 'bar' to be in the context");
        (new Organizer())->reduce([InvalidAttributedAction::class]);
    }

    /**
     * Test that reserved keys are still rejected when declared as an attribute
     */
    public function testOrganizerRaisesOnReservedKeysDeclaredAsAttributes(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('cannot be a reserved key');
        (new Organizer())->reduce([AttributedActionWithReservedKey::class]);
    }
}

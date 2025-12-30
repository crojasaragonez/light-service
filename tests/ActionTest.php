<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{
    protected static ValidAction $action;

    protected function setUp(): void
    {
        self::$action = new ValidAction();
    }

    /**
     * Test that action class has the correct attributes
     */
    public function testClassAttributes(): void
    {
        $this->assertTrue(property_exists(ValidAction::class, 'expects'));
        $this->assertTrue(property_exists(ValidAction::class, 'promises'));
    }

    /**
     * Test that action class has the correct attribute values
     */
    public function testClassAttributeValues(): void
    {
        $this->assertEquals(self::$action->expects, ['foo']);
        $this->assertEquals(self::$action->promises, ['bar']);
    }

    /**
     * Test that the execute method modifies the context correctly
     */
    public function testExecuteModifiesContext(): void
    {
        $context = [];
        $action = new ValidAction($context);
        $action->execute();
        $this->assertEquals(['bar' => 1], $action->context);
    }
}

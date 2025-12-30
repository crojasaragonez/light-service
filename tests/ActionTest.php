<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class ActionTest extends \PHPUnit\Framework\TestCase
{
    protected static $action;

    protected function setUp(): void
    {
        self::$action = new ValidAction();
    }

    /**
     * Test that action class has the correct attributes
     */
    public function testClassAttributes()
    {
        $this->assertTrue(property_exists(ValidAction::class, 'expects'));
        $this->assertTrue(property_exists(ValidAction::class, 'promises'));
    }

    /**
     * Test that action class has the correct attribute values
     */
    public function testClassAttributeValues()
    {
        $this->assertEquals(self::$action->expects, ['foo']);
        $this->assertEquals(self::$action->promises, ['bar']);
    }

    /**
     * Test that the execute method returns the right context
     */
    public function testExecuteReturnsValidContext()
    {
        $this->assertEquals(self::$action->execute([]), ['bar' => 1]);
    }
}

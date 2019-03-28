<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use Exception;

class OrganizerTest extends \PHPUnit\Framework\TestCase
{
    protected static $organizer;

    protected function setUp(): void
    {
        self::$organizer = new Organizer();
    }

    /**
     * Test that organizer does not fail when no actions were given
     */
    public function testReduceWithEmptyActions()
    {
        $this->assertEquals(self::$organizer->reduce(), []);
    }

    /**
     * Test that expectation and promises are all met
     */
    public function testReduceWithExpectationsAndPromisesMet()
    {
        self::$organizer = new Organizer(['foo' => 1]);
        $this->assertEquals(self::$organizer->reduce([ValidAction::class]), ['foo' => 1, 'bar' => 1]);
    }

    /**
     * Test that organizer raises an error when expectations are missing
     */
    public function testReduceWithMissingExpectations()
    {
        $this->expectException(Exception::class);
        self::$organizer->reduce([ValidAction::class]);
    }

    /**
     * Test that organizer raises an error when promises broken :(
     */
    public function testReduceWithBrokenPromises()
    {
        $this->expectException(Exception::class);
        self::$organizer->reduce([InvalidAction::class]);
    }

    /**
     * Test that organizer skips promise validation when skipRemaining was called
     */
    public function testReduceWithSkipRemainingBrokenPromises()
    {
        $this->assertEquals(self::$organizer->reduce([SkipInvalidAction::class]), []);
    }

    /**
     * Test that organizer skips actions once the flag skip_remaining is set to true
     */
    public function testThatOrganizerSkipsActionsWhenFlagSkipRemainingIsTrue()
    {
        $this->assertEquals(self::$organizer->reduce([SkipAction::class,
                                                      ValidAction::class]), []);
    }

    /**
     * Test that the organizer removes all reserved keys before finishing
     */
    public function testThatOrganizerRemovesAllReservedKeysBeforeFinishing()
    {
        self::$organizer = new Organizer([Organizer::SKIP_REMAINING => 1]);
        $this->assertEquals(self::$organizer->reduce([SkipAction::class,
                                                      ValidAction::class]), []);
    }


    /**
     * Test that organizer raises an exception when there is an action with a reserved key
     */
    public function testThatOrganizerRaisesExceptionWhereReservedKeysAreUsed()
    {
        $this->expectException(Exception::class);
        self::$organizer->reduce([ActionWithReservedKey::class]);
    }
}

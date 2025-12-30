<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use Exception;
use PHPUnit\Framework\TestCase;

class OrganizerTest extends TestCase
{
    protected static Organizer $organizer;

    protected function setUp(): void
    {
        self::$organizer = new Organizer();
    }

    /**
     * Test that organizer does not fail when no actions were given
     */
    public function testReduceWithEmptyActions(): void
    {
        $this->assertEquals(self::$organizer->reduce(), []);
    }

    /**
     * Test that expectation and promises are all met
     */
    public function testReduceWithExpectationsAndPromisesMet(): void
    {
        self::$organizer = new Organizer(['foo' => 1]);
        $this->assertEquals(self::$organizer->reduce([ValidAction::class]), ['foo' => 1, 'bar' => 1]);
    }

    /**
     * Test that organizer raises an error when expectations are missing
     */
    public function testReduceWithMissingExpectations(): void
    {
        $this->expectException(Exception::class);
        self::$organizer->reduce([ValidAction::class]);
    }

    /**
     * Test that organizer raises an error when promises broken :(
     */
    public function testReduceWithBrokenPromises(): void
    {
        $this->expectException(Exception::class);
        self::$organizer->reduce([InvalidAction::class]);
    }

    /**
     * Test that organizer skips promise validation when skipRemaining was called
     */
    public function testReduceWithSkipRemainingBrokenPromises(): void
    {
        $this->assertEquals(self::$organizer->reduce([SkipInvalidAction::class]), []);
    }

    /**
     * Test that organizer skips actions once the flag skip_remaining is set to true
     */
    public function testThatOrganizerSkipsActionsWhenFlagSkipRemainingIsTrue(): void
    {
        $this->assertEquals(self::$organizer->reduce([SkipAction::class, ValidAction::class]), []);
    }

    /**
     * Test that the organizer removes all reserved keys before finishing
     */
    public function testThatOrganizerRemovesAllReservedKeysBeforeFinishing(): void
    {
        self::$organizer = new Organizer([Organizer::SKIP_REMAINING => 1]);
        $this->assertEquals(self::$organizer->reduce([SkipAction::class, ValidAction::class]), []);
    }

    /**
     * Test that organizer raises an exception when there is an action with a reserved key
     */
    public function testThatOrganizerRaisesExceptionWhereReservedKeysAreUsed(): void
    {
        $this->expectException(Exception::class);
        self::$organizer->reduce([ActionWithReservedKey::class]);
    }

    /**
     * Test that progress callback is called with correct values
     */
    public function testProgressCallbackIsCalledWithCorrectValues(): void
    {
        self::$organizer = new Organizer(['foo' => 1]);
        $progressCalls = [];

        self::$organizer->reduce(
            [ValidAction::class],
            function (int $current, int $total, string $action, bool $skipped) use (&$progressCalls) {
                $progressCalls[] = compact('current', 'total', 'action', 'skipped');
            }
        );

        $this->assertCount(1, $progressCalls);
        $this->assertEquals(1, $progressCalls[0]['current']);
        $this->assertEquals(1, $progressCalls[0]['total']);
        $this->assertEquals(ValidAction::class, $progressCalls[0]['action']);
        $this->assertFalse($progressCalls[0]['skipped']);
    }

    /**
     * Test that progress callback tracks multiple actions correctly
     */
    public function testProgressCallbackTracksMultipleActions(): void
    {
        self::$organizer = new Organizer(['foo' => 1]);
        $progressCalls = [];

        self::$organizer->reduce(
            [ValidAction::class, ValidAction::class],
            function (int $current, int $total, string $action, bool $skipped) use (&$progressCalls) {
                $progressCalls[] = compact('current', 'total', 'action', 'skipped');
            }
        );

        $this->assertCount(2, $progressCalls);
        $this->assertEquals(1, $progressCalls[0]['current']);
        $this->assertEquals(2, $progressCalls[0]['total']);
        $this->assertEquals(2, $progressCalls[1]['current']);
        $this->assertEquals(2, $progressCalls[1]['total']);
    }

    /**
     * Test that progress callback reports skipped actions correctly
     */
    public function testProgressCallbackReportsSkippedActions(): void
    {
        self::$organizer = new Organizer(['foo' => 1]);
        $progressCalls = [];

        self::$organizer->reduce(
            [SkipAction::class, ValidAction::class],
            function (int $current, int $total, string $action, bool $skipped) use (&$progressCalls) {
                $progressCalls[] = compact('current', 'total', 'action', 'skipped');
            }
        );

        $this->assertCount(2, $progressCalls);
        $this->assertFalse($progressCalls[0]['skipped']);
        $this->assertEquals(SkipAction::class, $progressCalls[0]['action']);
        $this->assertTrue($progressCalls[1]['skipped']);
        $this->assertEquals(ValidAction::class, $progressCalls[1]['action']);
    }
}

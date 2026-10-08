<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex07ArrayFirstLast;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Workshop\Ex07ArrayFirstLast\RaceResults;
use Workshop\Tests\Support\Source;

final class RaceResultsTest extends TestCase
{
    private RaceResults $results;
    private RaceResults $noFinishers;

    protected function setUp(): void
    {
        $this->results = new RaceResults([
            ['driver' => 'Ada', 'team' => 'Red'],
            ['driver' => 'Linus', 'team' => 'Blue'],
            ['driver' => 'Grace', 'team' => 'Green'],
            ['driver' => 'Rasmus', 'team' => 'Blue'],
            ['driver' => 'Margaret', 'team' => 'Green'],
            ['driver' => 'Dennis', 'team' => 'Red'],
            ['driver' => 'Barbara', 'team' => 'Yellow'],
        ]);
        $this->noFinishers = new RaceResults([]);
    }

    public function testWinner(): void
    {
        self::assertSame('Ada', $this->results->winner());
        self::assertNull($this->noFinishers->winner());
    }

    public function testLastFinisher(): void
    {
        self::assertSame('Barbara', $this->results->lastFinisher());
        self::assertNull($this->noFinishers->lastFinisher());
    }

    public function testBestOfTeam(): void
    {
        self::assertSame('Ada', $this->results->bestOfTeam('Red'));
        self::assertSame('Linus', $this->results->bestOfTeam('Blue'));
        self::assertSame('Barbara', $this->results->bestOfTeam('Yellow'));
        self::assertNull($this->results->bestOfTeam('Purple'));
    }

    public function testWorstOfTeam(): void
    {
        self::assertSame('Dennis', $this->results->worstOfTeam('Red'));
        self::assertSame('Rasmus', $this->results->worstOfTeam('Blue'));
        self::assertSame('Margaret', $this->results->worstOfTeam('Green'));
        self::assertSame('Barbara', $this->results->worstOfTeam('Yellow'));
        self::assertNull($this->results->worstOfTeam('Purple'));
        self::assertNull($this->noFinishers->worstOfTeam('Red'));
    }

    public function testItUsesTheNewFunctions(): void
    {
        $source = Source::ofClass(RaceResults::class);

        self::assertGreaterThanOrEqual(1, $source->countCalls('array_first'), 'Use array_first().');
        self::assertGreaterThanOrEqual(1, $source->countCalls('array_last'), 'Use array_last().');
    }

    /** @return iterable<string, array{string}> */
    public static function forbidden(): iterable
    {
        $functions = [
            'reset', 'end', 'current', 'count', 'array_values', 'array_slice',
            'array_pop', 'array_shift', 'array_key_first', 'array_key_last',
        ];

        foreach ($functions as $function) {
            yield $function => [$function];
        }
    }

    #[DataProvider('forbidden')]
    public function testItDoesNotUse(string $function): void
    {
        self::assertSame(0, Source::ofClass(RaceResults::class)->countCalls($function), "Do not use $function().");
    }
}

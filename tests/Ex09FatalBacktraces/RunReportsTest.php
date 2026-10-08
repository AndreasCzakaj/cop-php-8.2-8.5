<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex09FatalBacktraces;

use PHPUnit\Framework\TestCase;

final class RunReportsTest extends TestCase
{
    private const string SCRIPT = __DIR__ . '/../../src/Ex09FatalBacktraces/run-reports.php';

    private static int $exitCode;
    private static string $output;

    public static function setUpBeforeClass(): void
    {
        $process = proc_open(
            [PHP_BINARY, self::SCRIPT],
            [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes,
        );
        self::assertIsResource($process);

        self::$output = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
        self::$exitCode = proc_close($process);
    }

    public function testTheJobFinishesWithoutAFatalError(): void
    {
        self::assertStringNotContainsString('Fatal error', self::$output);
        self::assertSame(0, self::$exitCode, 'run-reports.php must exit with code 0.');
    }

    public function testAllThreeReportsArePrinted(): void
    {
        foreach (['Customers', 'Orders', 'Inventory'] as $title) {
            self::assertMatchesRegularExpression("/^$title$/m", self::$output, "The report \"$title\" is missing.");
        }

        self::assertStringContainsString('| Ada Lovelace | London', self::$output);
        self::assertStringContainsString('| Keyboard | 4006381333931 | 12', self::$output);
    }

    public function testTheTablesAreNoWiderThanNecessary(): void
    {
        $longest = max(array_map(mb_strlen(...), explode(PHP_EOL, self::$output)));

        self::assertLessThanOrEqual(60, $longest, 'A column is far wider than its content.');
    }

    public function testTheMemoryLimitWasNotRaised(): void
    {
        self::assertStringContainsString("ini_set('memory_limit', '64M');", (string) file_get_contents(self::SCRIPT));
    }
}

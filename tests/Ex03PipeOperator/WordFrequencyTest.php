<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex03PipeOperator;

use PHPUnit\Framework\TestCase;
use Workshop\Ex03PipeOperator\WordFrequency;
use Workshop\Tests\Support\Source;

final class WordFrequencyTest extends TestCase
{
    public function testTheExampleFromTheTask(): void
    {
        self::assertSame(['the' => 2, 'and' => 1], WordFrequency::top('The cat and the hat', 2));
    }

    public function testMostFrequentFirstThenAlphabetical(): void
    {
        $text = 'The quick brown fox. The lazy dog; the END, the end!';

        self::assertSame(
            ['the' => 4, 'end' => 2, 'brown' => 1, 'dog' => 1],
            WordFrequency::top($text, 4),
        );
    }

    public function testDigitsAndPunctuationSeparateWords(): void
    {
        self::assertSame(
            ['php' => 3, 'is' => 1, 'not' => 1],
            WordFrequency::top('PHP8 is not php-5, (PHP)', 10),
        );
    }

    public function testUmlautsAreLetters(): void
    {
        self::assertSame(
            ['äpfel' => 2, 'öl' => 1],
            WordFrequency::top('Äpfel, äpfel, Öl', 5),
        );
    }

    public function testEmptyText(): void
    {
        self::assertSame([], WordFrequency::top('', 3));
        self::assertSame([], WordFrequency::top(' 123 ... ', 3));
    }

    public function testItIsWrittenAsAPipeChain(): void
    {
        $source = Source::ofClass(WordFrequency::class);

        self::assertGreaterThanOrEqual(4, $source->count('|>'), 'Use the pipe operator at least four times.');
    }
}

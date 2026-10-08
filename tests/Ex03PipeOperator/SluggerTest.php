<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex03PipeOperator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Workshop\Ex03PipeOperator\Slugger;
use Workshop\Tests\Support\Source;

final class SluggerTest extends TestCase
{
    /** @return iterable<string, array{string, string}> */
    public static function titles(): iterable
    {
        yield 'simple' => ['Hello World', 'hello-world'];
        yield 'whitespace and punctuation' => ['  What\'s new in PHP 8.5?! ', 'what-s-new-in-php-8-5'];
        yield 'umlauts' => ['Größe & Maße: Übersicht', 'groesse-masse-uebersicht'];
        yield 'empty' => ['', ''];
    }

    #[DataProvider('titles')]
    public function testSlugify(string $title, string $expected): void
    {
        self::assertSame($expected, Slugger::slugify($title));
    }

    public function testItIsWrittenAsAPipeChain(): void
    {
        $source = Source::ofClass(Slugger::class);

        self::assertGreaterThanOrEqual(4, $source->count('|>'), 'Use the pipe operator at least four times.');
        self::assertSame(1, $source->count('return'), 'slugify() must be a single return statement.');
        self::assertSame(
            2,
            $source->count('='),
            'No temporary variables: only declare() and the constant may contain a "=".',
        );
    }
}

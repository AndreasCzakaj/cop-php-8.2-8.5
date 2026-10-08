<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex08ClosuresInConstExpr;

use Closure;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use ReflectionMethod;
use Workshop\Ex08ClosuresInConstExpr\TextFilters;
use Workshop\Tests\Support\Source;

final class TextFiltersTest extends TestCase
{
    public function testTheConstantHoldsTheFourFilters(): void
    {
        self::assertSame(['trim', 'upper', 'lower', 'snake'], array_keys(TextFilters::FILTERS));
        self::assertContainsOnlyInstancesOf(Closure::class, TextFilters::FILTERS);
    }

    public function testBuiltInFiltersAreFirstClassCallables(): void
    {
        $expected = ['trim' => 'trim', 'upper' => 'mb_strtoupper', 'lower' => 'mb_strtolower'];

        foreach ($expected as $filter => $function) {
            self::assertArrayHasKey($filter, TextFilters::FILTERS);
            self::assertSame(
                $function,
                new ReflectionFunction(TextFilters::FILTERS[$filter])->getName(),
                "The filter '$filter' must be $function(...).",
            );
        }
    }

    public function testSnakeIsAClosureWrittenInTheConstant(): void
    {
        self::assertArrayHasKey('snake', TextFilters::FILTERS);

        $snake = new ReflectionFunction(TextFilters::FILTERS['snake']);
        self::assertTrue($snake->isAnonymous(), "'snake' must be a closure, not a named function.");
        self::assertSame('hello_big_world', (TextFilters::FILTERS['snake'])("Hello  big\tWorld"));
    }

    public function testApplyRunsTheFiltersFromLeftToRight(): void
    {
        self::assertSame('hello_world', TextFilters::apply('  Hello World ', 'trim', 'snake'));
        self::assertSame('_hello_world_', TextFilters::apply('  Hello World ', 'snake', 'trim'));
        self::assertSame('GRÖSSE', TextFilters::apply(' größe ', 'upper', 'trim'));
        self::assertSame('äpfel', TextFilters::apply('ÄPFEL', 'lower'));
    }

    public function testApplyWithoutFiltersReturnsTheText(): void
    {
        self::assertSame(' Hello ', TextFilters::apply(' Hello '));
    }

    public function testApplyRejectsUnknownFilters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        TextFilters::apply('Hello', 'trim', 'rot13');
    }

    public function testApplyLooksTheFiltersUpInTheConstant(): void
    {
        $source = Source::ofClass(TextFilters::class);

        self::assertSame(0, $source->count('match'), 'Do not use match.');
        self::assertSame(0, $source->count('switch'), 'Do not use switch.');
    }

    public function testShoutHasACallableAsDefaultValue(): void
    {
        $parameter = new ReflectionMethod(TextFilters::class, 'shout')->getParameters()[1];

        self::assertTrue($parameter->isDefaultValueAvailable(), '$transform needs a default value.');
        self::assertInstanceOf(Closure::class, $parameter->getDefaultValue());
        self::assertSame('HI!', TextFilters::shout('hi'));
    }

    public function testShoutStillAcceptsAnotherCallable(): void
    {
        self::assertSame('ih!', TextFilters::shout('hi', strrev(...)));
    }
}

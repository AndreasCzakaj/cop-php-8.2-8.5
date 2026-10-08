<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex04CloneWith;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Workshop\Ex04CloneWith\Money;
use Workshop\Tests\Support\Source;

final class MoneyTest extends TestCase
{
    public function testWithAmountReturnsAModifiedCopy(): void
    {
        $price = new Money(1999, 'EUR');
        $discounted = $price->withAmount(1499);

        self::assertNotSame($price, $discounted);
        self::assertSame(1499, $discounted->amount);
        self::assertSame('EUR', $discounted->currency);
        self::assertSame(1999, $price->amount, 'The original must not change.');
    }

    public function testWithCurrencyReturnsAModifiedCopy(): void
    {
        $price = new Money(1999, 'EUR');
        $converted = $price->withCurrency('USD');

        self::assertNotSame($price, $converted);
        self::assertSame(1999, $converted->amount);
        self::assertSame('USD', $converted->currency);
        self::assertSame('EUR', $price->currency, 'The original must not change.');
    }

    public function testAdd(): void
    {
        $a = new Money(1000, 'EUR');
        $b = new Money(250, 'EUR');
        $sum = $a->add($b);

        self::assertSame(1250, $sum->amount);
        self::assertSame('EUR', $sum->currency);
        self::assertSame(1000, $a->amount);
        self::assertSame(250, $b->amount);
    }

    public function testAddRejectsDifferentCurrencies(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Money(1000, 'EUR')->add(new Money(250, 'USD'));
    }

    public function testTheConstructorStillValidates(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Money(-1, 'EUR');
    }

    public function testWithAmountValidates(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Money(1000, 'EUR')->withAmount(-1);
    }

    public function testWithCurrencyValidates(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Money(1000, 'EUR')->withCurrency('euro');
    }

    public function testItUsesCloneInsteadOfTheConstructor(): void
    {
        $source = Source::ofClass(Money::class);

        self::assertGreaterThanOrEqual(1, $source->countCalls('clone'), 'Use clone($this, [...]).');
        foreach (['self', 'static', 'money'] as $name) {
            self::assertSame(0, $source->countSequence('new', $name), "Do not use \"new $name\".");
        }

        $class = new ReflectionClass(Money::class);
        self::assertTrue($class->isReadOnly() && $class->isFinal(), 'Money must stay final readonly.');
    }
}

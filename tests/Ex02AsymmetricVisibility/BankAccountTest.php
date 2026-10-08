<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex02AsymmetricVisibility;

use DomainException;
use Error;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Workshop\Ex02AsymmetricVisibility\BankAccount;

final class BankAccountTest extends TestCase
{
    public function testANewAccountIsEmpty(): void
    {
        $account = new BankAccount('Ada');

        self::assertSame('Ada', $account->owner);
        self::assertSame(0, $account->balance);
        self::assertSame([], $account->transactions);
    }

    public function testDepositsAndWithdrawalsAreBooked(): void
    {
        $account = new BankAccount('Ada');
        $account->deposit(5000);
        $account->withdraw(1250);
        $account->deposit(1);

        self::assertSame(3751, $account->balance);
        self::assertSame([5000, -1250, 1], $account->transactions);
    }

    public function testTheWholeBalanceCanBeWithdrawn(): void
    {
        $account = new BankAccount('Ada');
        $account->deposit(100);
        $account->withdraw(100);

        self::assertSame(0, $account->balance);
    }

    public function testOverdrawingIsRejected(): void
    {
        $account = new BankAccount('Ada');
        $account->deposit(100);

        try {
            $account->withdraw(101);
            self::fail('Overdrawing must throw a DomainException.');
        } catch (DomainException) {
            self::assertSame(100, $account->balance);
            self::assertSame([100], $account->transactions);
        }
    }

    /** @return iterable<string, array{string, int}> */
    public static function invalidAmounts(): iterable
    {
        yield 'deposit 0' => ['deposit', 0];
        yield 'deposit negative' => ['deposit', -5];
        yield 'withdraw 0' => ['withdraw', 0];
        yield 'withdraw negative' => ['withdraw', -5];
    }

    #[DataProvider('invalidAmounts')]
    public function testAmountsMustBePositive(string $method, int $cents): void
    {
        $account = new BankAccount('Ada');
        $account->deposit(100);

        $this->expectException(InvalidArgumentException::class);
        $account->$method($cents);
    }

    public function testTheBalanceCannotBeWrittenFromOutside(): void
    {
        $account = new BankAccount('Ada');

        $this->expectException(Error::class);
        $account->balance = 1_000_000;
    }

    public function testTransactionsCannotBeAppendedFromOutside(): void
    {
        $account = new BankAccount('Ada');

        $this->expectException(Error::class);
        $account->transactions[] = 1_000_000;
    }

    public function testTheOwnerCannotBeChanged(): void
    {
        $account = new BankAccount('Ada');

        $this->expectException(Error::class);
        $account->owner = 'Mallory';
    }

    #[DataProvider('guardedProperties')]
    public function testPropertiesArePublicReadPrivateWrite(string $name): void
    {
        $class = new ReflectionClass(BankAccount::class);
        self::assertTrue($class->hasProperty($name), "Missing property $name.");

        $property = $class->getProperty($name);
        self::assertTrue($property->isPublic(), "$name must be publicly readable.");
        self::assertTrue($property->isPrivateSet(), "$name must be private(set).");
        self::assertFalse($property->isReadOnly(), "$name must not be readonly.");
    }

    /** @return iterable<string, array{string}> */
    public static function guardedProperties(): iterable
    {
        yield 'balance' => ['balance'];
        yield 'transactions' => ['transactions'];
    }

    public function testThereAreNoGetters(): void
    {
        $methods = array_map(
            static fn ($method) => $method->getName(),
            new ReflectionClass(BankAccount::class)->getMethods(\ReflectionMethod::IS_PUBLIC),
        );
        sort($methods);

        self::assertSame(['__construct', 'deposit', 'withdraw'], $methods);
    }
}

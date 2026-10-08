<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex01PropertyHooks;

use Error;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;
use Workshop\Ex01PropertyHooks\User;

final class UserTest extends TestCase
{
    public function testNamesAreReadableAndWritable(): void
    {
        $user = new User('Ada', 'Lovelace', 'ada@example.com');
        $user->firstName = 'Augusta';

        self::assertSame('Augusta', $user->firstName);
        self::assertSame('Lovelace', $user->lastName);
    }

    public function testEmailIsNormalisedInTheConstructor(): void
    {
        $user = new User('Ada', 'Lovelace', '  Ada.Lovelace@Example.COM ');

        self::assertSame('ada.lovelace@example.com', $user->email);
    }

    public function testEmailIsNormalisedOnEveryWrite(): void
    {
        $user = new User('Ada', 'Lovelace', 'ada@example.com');
        $user->email = ' COUNTESS@Example.com';

        self::assertSame('countess@example.com', $user->email);
    }

    public function testInvalidEmailIsRejectedInTheConstructor(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new User('Ada', 'Lovelace', 'not-an-email');
    }

    public function testInvalidEmailIsRejectedOnWrite(): void
    {
        $user = new User('Ada', 'Lovelace', 'ada@example.com');

        try {
            $user->email = 'not-an-email';
            self::fail('Writing an invalid email must throw an InvalidArgumentException.');
        } catch (InvalidArgumentException) {
            self::assertSame('ada@example.com', $user->email, 'The old value must survive.');
        }
    }

    public function testFullNameFollowsTheNames(): void
    {
        $user = new User('Ada', 'Lovelace', 'ada@example.com');
        self::assertSame('Ada Lovelace', $user->fullName);

        $user->lastName = 'King';
        self::assertSame('Ada King', $user->fullName);
    }

    public function testFullNameIsVirtualAndCannotBeWritten(): void
    {
        self::assertTrue(
            new ReflectionProperty(User::class, 'fullName')->isVirtual(),
            'fullName must be a virtual property.',
        );

        $user = new User('Ada', 'Lovelace', 'ada@example.com');

        $this->expectException(Error::class);
        $user->fullName = 'Grace Hopper';
    }

    public function testTheClassHasNoGettersOrSetters(): void
    {
        $methods = array_map(
            static fn ($method) => $method->getName(),
            new ReflectionClass(User::class)->getMethods(),
        );

        self::assertSame(['__construct'], $methods);
        self::assertTrue(new ReflectionProperty(User::class, 'email')->hasHooks(), 'email needs a hook.');
    }
}

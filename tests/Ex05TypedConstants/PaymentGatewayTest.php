<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex05TypedConstants;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClassConstant;
use Workshop\Ex05TypedConstants\KlarnaGateway;
use Workshop\Ex05TypedConstants\PaymentGateway;
use Workshop\Ex05TypedConstants\PaypalGateway;
use Workshop\Ex05TypedConstants\StripeGateway;

final class PaymentGatewayTest extends TestCase
{
    private const array TYPES = [
        'NAME' => 'string',
        'FEE_PERCENT' => 'float',
        'FIXED_FEE_CENTS' => 'int',
        'SUPPORTED_CURRENCIES' => 'array',
    ];

    /** @return iterable<string, array{class-string, string, string}> */
    public static function constants(): iterable
    {
        foreach ([PaymentGateway::class, StripeGateway::class, PaypalGateway::class, KlarnaGateway::class] as $class) {
            foreach (self::TYPES as $constant => $type) {
                $shortName = substr((string) strrchr($class, '\\'), 1);
                yield "$shortName::$constant" => [$class, $constant, $type];
            }
        }
    }

    #[DataProvider('constants')]
    public function testEveryConstantIsTyped(string $class, string $constant, string $type): void
    {
        $reflection = new ReflectionClassConstant($class, $constant);

        self::assertSame($class, $reflection->getDeclaringClass()->getName());
        self::assertSame($type, (string) $reflection->getType(), "$constant must be declared as $type.");
    }

    /** @return iterable<string, array{PaymentGateway, int, int}> */
    public static function fees(): iterable
    {
        yield 'Stripe 100.00' => [new StripeGateway(), 10_000, 175];
        yield 'Stripe 9.99' => [new StripeGateway(), 999, 40];
        yield 'PayPal 100.00' => [new PaypalGateway(), 10_000, 325];
        yield 'PayPal 9.99' => [new PaypalGateway(), 999, 64];
        yield 'Klarna 100.00' => [new KlarnaGateway(), 10_000, 345];
        yield 'Klarna 9.99' => [new KlarnaGateway(), 999, 52];
    }

    #[DataProvider('fees')]
    public function testFee(PaymentGateway $gateway, int $amountCents, int $expectedFee): void
    {
        self::assertSame($expectedFee, $gateway->fee($amountCents));
    }

    public function testSupportedCurrencies(): void
    {
        self::assertTrue(new StripeGateway()->supports('GBP'));
        self::assertTrue(new PaypalGateway()->supports('USD'));
        self::assertFalse(new PaypalGateway()->supports('GBP'));
        self::assertTrue(new KlarnaGateway()->supports('EUR'));
        self::assertFalse(new KlarnaGateway()->supports('USD'));
    }
}

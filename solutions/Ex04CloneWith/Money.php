<?php

declare(strict_types=1);

namespace Workshop\Ex04CloneWith;

use InvalidArgumentException;

final readonly class Money
{
    public function __construct(
        public int $amount,
        public string $currency,
    ) {
        self::assertAmount($amount);
        self::assertCurrency($currency);
    }

    public function withAmount(int $amount): self
    {
        return clone($this, ['amount' => self::assertAmount($amount)]);
    }

    public function withCurrency(string $currency): self
    {
        return clone($this, ['currency' => self::assertCurrency($currency)]);
    }

    public function add(self $other): self
    {
        if ($other->currency !== $this->currency) {
            throw new InvalidArgumentException('Cannot add amounts in different currencies.');
        }

        return $this->withAmount($this->amount + $other->amount);
    }

    private static function assertAmount(int $amount): int
    {
        return $amount >= 0 ? $amount : throw new InvalidArgumentException('The amount must not be negative.');
    }

    private static function assertCurrency(string $currency): string
    {
        return preg_match('/^[A-Z]{3}$/', $currency) === 1
            ? $currency
            : throw new InvalidArgumentException('The currency must be a three-letter code such as EUR.');
    }
}

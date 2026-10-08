<?php

declare(strict_types=1);

namespace Workshop\Ex02AsymmetricVisibility;

use DomainException;
use InvalidArgumentException;

final class BankAccount
{
    public private(set) int $balance = 0;

    /** @var list<int> */
    public private(set) array $transactions = [];

    public function __construct(public readonly string $owner)
    {
    }

    public function deposit(int $cents): void
    {
        $this->book(self::positive($cents));
    }

    public function withdraw(int $cents): void
    {
        if (self::positive($cents) > $this->balance) {
            throw new DomainException('Insufficient funds.');
        }

        $this->book(-$cents);
    }

    private function book(int $cents): void
    {
        $this->balance += $cents;
        $this->transactions[] = $cents;
    }

    private static function positive(int $cents): int
    {
        return $cents > 0 ? $cents : throw new InvalidArgumentException('The amount must be greater than 0.');
    }
}

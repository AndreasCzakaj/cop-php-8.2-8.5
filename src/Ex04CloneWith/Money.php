<?php

declare(strict_types=1);

namespace Workshop\Ex04CloneWith;

use InvalidArgumentException;

/**
 * EXERCISE 04 / TASK 1: clone with - "withers" for an immutable value object
 * (PHP 8.5)
 *
 * PROBLEM
 *   Immutable objects are changed by creating a modified copy. Until now
 *   every with*() method had to call the constructor and repeat ALL
 *   arguments, which gets worse with every property that is added.
 *   Since PHP 8.5 clone() takes a second argument:
 *
 *     clone($object, ['property' => $newValue])
 *
 * TASK
 *   Implement the three methods below. Each returns a NEW Money object and
 *   leaves the original untouched.
 *
 *   - withAmount()    Copy with another amount.
 *   - withCurrency()  Copy with another currency.
 *   - add()           Copy whose amount is the sum of both amounts. Throws an
 *                     \InvalidArgumentException if the currencies differ.
 *
 *   The rules checked by the constructor must hold for the copies as well:
 *   withAmount(-1) and withCurrency('euro') throw an \InvalidArgumentException.
 *
 * CONSTRAINTS
 *   - Use clone() with the second argument.
 *   - Do not create Money objects with "new" inside this class.
 *   - The class stays "final readonly".
 *
 * HINTS
 *   - clone does NOT run the constructor. What does that mean for the
 *     validation? Restructure the given code as you like.
 *
 * VERIFY
 *   make test ex=04
 */
final readonly class Money
{
    public function __construct(
        public int $amount,
        public string $currency,
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException('The amount must not be negative.');
        }

        if (preg_match('/^[A-Z]{3}$/', $currency) !== 1) {
            throw new InvalidArgumentException('The currency must be a three-letter code such as EUR.');
        }
    }

    public function withAmount(int $amount): self
    {
        throw new \LogicException('TODO: implement ' . __METHOD__);
    }

    public function withCurrency(string $currency): self
    {
        throw new \LogicException('TODO: implement ' . __METHOD__);
    }

    public function add(self $other): self
    {
        throw new \LogicException('TODO: implement ' . __METHOD__);
    }
}

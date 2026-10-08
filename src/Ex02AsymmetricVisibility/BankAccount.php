<?php

declare(strict_types=1);

namespace Workshop\Ex02AsymmetricVisibility;

/**
 * EXERCISE 02 / TASK 1: Asymmetric visibility - a bank account
 * (PHP 8.4)
 *
 * PROBLEM
 *   "Everybody may read it, only the class may change it" used to require a
 *   private property plus a getter. "readonly" is no alternative here because
 *   a balance has to change over time.
 *
 * TASK
 *   Implement the account with these public members:
 *
 *   - owner (string)         Set once in the constructor, never changes.
 *   - balance (int, cents)   Starts at 0. Readable from everywhere, writable
 *                            only inside this class.
 *   - transactions (int[])   Every booked amount in order: deposits positive,
 *                            withdrawals negative. Readable from everywhere,
 *                            writable only inside this class.
 *   - deposit(int $cents)    Adds to the balance.
 *   - withdraw(int $cents)   Subtracts from the balance. Throws a
 *                            \DomainException if the balance is too low.
 *
 *   deposit() and withdraw() throw an \InvalidArgumentException for amounts
 *   that are not greater than 0.
 *
 * CONSTRAINTS
 *   - No getter methods: deposit, withdraw and __construct are the only ones.
 *   - balance and transactions must not be readonly.
 *
 * HINTS
 *   - public private(set) int $balance = 0;
 *   - Try $account->transactions[] = 100; from outside. What happens, and why
 *     is that different from a private property behind a getter?
 *
 * VERIFY
 *   make test ex=02
 */
final class BankAccount
{
    // TODO: declare the properties

    public function __construct(string $owner)
    {
        // TODO
    }

    public function deposit(int $cents): void
    {
        throw new \LogicException('TODO: implement ' . __METHOD__);
    }

    public function withdraw(int $cents): void
    {
        throw new \LogicException('TODO: implement ' . __METHOD__);
    }
}

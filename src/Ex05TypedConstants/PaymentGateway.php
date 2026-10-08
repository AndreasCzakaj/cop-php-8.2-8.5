<?php

declare(strict_types=1);

namespace Workshop\Ex05TypedConstants;

/**
 * EXERCISE 05: Typed class constants - let PHP find the bugs
 * (PHP 8.3)
 *
 * PROBLEM
 *   This interface asks every gateway for four constants. Until PHP 8.3
 *   nothing could stop an implementation from overriding a constant with a
 *   value of a completely different type. Two of the three gateways in this
 *   directory do exactly that, and customers are charged wrong fees:
 *
 *     make test ex=05
 *
 * TASK
 *   1. Add a type to every constant of this interface:
 *        NAME                  string
 *        FEE_PERCENT           float
 *        FIXED_FEE_CENTS       int
 *        SUPPORTED_CURRENCIES  array
 *   2. Run the tests again. PHP now refuses to load the broken gateways and
 *      tells you which constant is wrong. Fix what it reports until the
 *      tests are green.
 *
 * CONSTRAINTS
 *   - Every constant in the interface AND in the three gateway classes
 *     carries a type.
 *   - Do not change AbstractGateway.
 *
 * HINTS
 *   - Syntax: const string NAME = '...';
 *   - The check happens at compile time, so the error is a fatal error and
 *     not a failing test. That is the point of this exercise.
 *
 * VERIFY
 *   make test ex=05
 */
interface PaymentGateway
{
    public const NAME = 'unknown';

    /** Percentage of the amount that is charged as a fee, e.g. 1.5 for 1.5 %. */
    public const FEE_PERCENT = 0.0;

    /** Fee per transaction in cents, charged on top of the percentage. */
    public const FIXED_FEE_CENTS = 0;

    /** ISO codes of the currencies the gateway can handle. */
    public const SUPPORTED_CURRENCIES = [];

    /** Fee in cents for a payment of the given amount in cents. */
    public function fee(int $amountCents): int;

    public function supports(string $currency): bool;
}

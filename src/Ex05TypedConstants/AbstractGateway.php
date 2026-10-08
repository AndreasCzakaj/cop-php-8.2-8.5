<?php

declare(strict_types=1);

namespace Workshop\Ex05TypedConstants;

/**
 * Part of EXERCISE 05. Given code: do not change this class.
 */
abstract class AbstractGateway implements PaymentGateway
{
    public function fee(int $amountCents): int
    {
        return (int) round($amountCents * static::FEE_PERCENT / 100) + static::FIXED_FEE_CENTS;
    }

    public function supports(string $currency): bool
    {
        return in_array($currency, static::SUPPORTED_CURRENCIES, true);
    }
}

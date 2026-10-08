<?php

declare(strict_types=1);

namespace Workshop\Ex05TypedConstants;

interface PaymentGateway
{
    public const string NAME = 'unknown';

    /** Percentage of the amount that is charged as a fee, e.g. 1.5 for 1.5 %. */
    public const float FEE_PERCENT = 0.0;

    /** Fee per transaction in cents, charged on top of the percentage. */
    public const int FIXED_FEE_CENTS = 0;

    /** ISO codes of the currencies the gateway can handle. */
    public const array SUPPORTED_CURRENCIES = [];

    /** Fee in cents for a payment of the given amount in cents. */
    public function fee(int $amountCents): int;

    public function supports(string $currency): bool;
}

<?php

declare(strict_types=1);

namespace Workshop\Ex05TypedConstants;

/**
 * Part of EXERCISE 05, see PaymentGateway.php for the task.
 */
final class StripeGateway extends AbstractGateway
{
    public const NAME = 'Stripe';
    public const FEE_PERCENT = 1.5;
    public const FIXED_FEE_CENTS = 25;
    public const SUPPORTED_CURRENCIES = ['EUR', 'USD', 'GBP'];
}

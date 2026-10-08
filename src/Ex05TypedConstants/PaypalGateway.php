<?php

declare(strict_types=1);

namespace Workshop\Ex05TypedConstants;

/**
 * Part of EXERCISE 05, see PaymentGateway.php for the task.
 *
 * Fees according to the contract: 2.9 % plus 35 cents per transaction.
 */
final class PaypalGateway extends AbstractGateway
{
    public const NAME = 'PayPal';
    public const FEE_PERCENT = '2,9';
    public const FIXED_FEE_CENTS = 35;
    public const SUPPORTED_CURRENCIES = ['EUR', 'USD'];
}

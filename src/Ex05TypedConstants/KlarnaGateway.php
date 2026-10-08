<?php

declare(strict_types=1);

namespace Workshop\Ex05TypedConstants;

/**
 * Part of EXERCISE 05, see PaymentGateway.php for the task.
 *
 * Fees according to the contract: 3.25 % plus 20 cents per transaction,
 * payments in EUR only.
 */
final class KlarnaGateway extends AbstractGateway
{
    public const NAME = 'Klarna';
    public const FEE_PERCENT = 3.25;
    public const FIXED_FEE_CENTS = '20';
    public const SUPPORTED_CURRENCIES = 'EUR';
}

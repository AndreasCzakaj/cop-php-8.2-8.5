<?php

declare(strict_types=1);

namespace Workshop\Ex05TypedConstants;

final class StripeGateway extends AbstractGateway
{
    public const string NAME = 'Stripe';
    public const float FEE_PERCENT = 1.5;
    public const int FIXED_FEE_CENTS = 25;
    public const array SUPPORTED_CURRENCIES = ['EUR', 'USD', 'GBP'];
}

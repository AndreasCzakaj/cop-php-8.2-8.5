<?php

declare(strict_types=1);

namespace Workshop\Ex05TypedConstants;

final class PaypalGateway extends AbstractGateway
{
    public const string NAME = 'PayPal';
    public const float FEE_PERCENT = 2.9;
    public const int FIXED_FEE_CENTS = 35;
    public const array SUPPORTED_CURRENCIES = ['EUR', 'USD'];
}

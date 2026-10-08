<?php

declare(strict_types=1);

namespace Workshop\Ex05TypedConstants;

final class KlarnaGateway extends AbstractGateway
{
    public const string NAME = 'Klarna';
    public const float FEE_PERCENT = 3.25;
    public const int FIXED_FEE_CENTS = 20;
    public const array SUPPORTED_CURRENCIES = ['EUR'];
}

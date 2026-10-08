<?php

declare(strict_types=1);

namespace Workshop\Ex01PropertyHooks;

final class Square implements Shape
{
    public float $area {
        get => $this->side ** 2;
    }

    public function __construct(public float $side)
    {
    }
}

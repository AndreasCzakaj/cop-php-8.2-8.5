<?php

declare(strict_types=1);

namespace Workshop\Ex01PropertyHooks;

use InvalidArgumentException;

final class Circle implements Shape
{
    public float $radius {
        set(float $value) {
            if ($value < 0) {
                throw new InvalidArgumentException('A circle cannot have a negative size.');
            }

            $this->radius = $value;
        }
    }

    public float $area {
        get => M_PI * $this->radius ** 2;
    }

    public float $diameter {
        get => $this->radius * 2;
        set(float $value) {
            $this->radius = $value / 2;
        }
    }

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }
}

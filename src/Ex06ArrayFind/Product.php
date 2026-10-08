<?php

declare(strict_types=1);

namespace Workshop\Ex06ArrayFind;

/**
 * Part of EXERCISE 06. Given code: do not change this class.
 */
final readonly class Product
{
    public function __construct(
        public string $name,
        public float $price,
        public int $stock,
        public bool $discontinued = false,
    ) {
    }
}

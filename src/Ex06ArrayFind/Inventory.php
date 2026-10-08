<?php

declare(strict_types=1);

namespace Workshop\Ex06ArrayFind;

/**
 * EXERCISE 06: array_find(), array_find_key(), array_any(), array_all()
 * (PHP 8.4)
 *
 * PROBLEM
 *   "Give me the first element that ...", "is there any element that ..." and
 *   "do all elements ..." are everyday questions. Until PHP 8.4 the answer
 *   was a hand-written loop or a misused array_filter(). This class is full
 *   of such loops. It works, and the behaviour tests are already green.
 *
 * TASK
 *   Replace every loop by the one new function that expresses the question.
 *   The behaviour must stay the same.
 *
 * CONSTRAINTS
 *   - No foreach, for or while in this file.
 *   - No array_filter().
 *   - Each of array_find, array_find_key, array_any and array_all is used at
 *     least once.
 *
 * HINTS
 *   - All four take ($array, $callback) and the callback receives
 *     ($value, $key).
 *   - array_find() and array_find_key() return null if nothing matches.
 *   - What do array_any() and array_all() return for an empty array?
 *
 * VERIFY
 *   make test ex=06
 */
final class Inventory
{
    /** @param array<string, Product> $products indexed by SKU */
    public function __construct(private array $products)
    {
    }

    /** The first product that is sold out, or null. */
    public function firstSoldOut(): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->stock === 0) {
                return $product;
            }
        }

        return null;
    }

    /** The first product whose SKU starts with the given prefix, or null. */
    public function firstWithSkuPrefix(string $prefix): ?Product
    {
        foreach ($this->products as $sku => $product) {
            if (str_starts_with($sku, $prefix)) {
                return $product;
            }
        }

        return null;
    }

    /** The SKU of the first product that costs more than the limit, or null. */
    public function skuOfFirstPricedAbove(float $limit): ?string
    {
        $found = null;
        foreach ($this->products as $sku => $product) {
            if ($found === null && $product->price > $limit) {
                $found = $sku;
            }
        }

        return $found;
    }

    /** Is at least one product discontinued? */
    public function hasDiscontinued(): bool
    {
        $discontinued = false;
        foreach ($this->products as $product) {
            if ($product->discontinued) {
                $discontinued = true;
                break;
            }
        }

        return $discontinued;
    }

    /** Can every product be delivered, i.e. is none sold out? */
    public function isFullyStocked(): bool
    {
        foreach ($this->products as $product) {
            if ($product->stock === 0) {
                return false;
            }
        }

        return true;
    }
}

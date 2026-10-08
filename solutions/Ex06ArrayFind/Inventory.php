<?php

declare(strict_types=1);

namespace Workshop\Ex06ArrayFind;

final class Inventory
{
    /** @param array<string, Product> $products indexed by SKU */
    public function __construct(private array $products)
    {
    }

    public function firstSoldOut(): ?Product
    {
        return array_find($this->products, static fn (Product $product): bool => $product->stock === 0);
    }

    public function firstWithSkuPrefix(string $prefix): ?Product
    {
        return array_find(
            $this->products,
            static fn (Product $product, string $sku): bool => str_starts_with($sku, $prefix),
        );
    }

    public function skuOfFirstPricedAbove(float $limit): ?string
    {
        return array_find_key($this->products, static fn (Product $product): bool => $product->price > $limit);
    }

    public function hasDiscontinued(): bool
    {
        return array_any($this->products, static fn (Product $product): bool => $product->discontinued);
    }

    public function isFullyStocked(): bool
    {
        return array_all($this->products, static fn (Product $product): bool => $product->stock > 0);
    }
}

<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex06ArrayFind;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Workshop\Ex06ArrayFind\Inventory;
use Workshop\Ex06ArrayFind\Product;
use Workshop\Tests\Support\Source;

final class InventoryTest extends TestCase
{
    private Inventory $inventory;
    private Inventory $healthy;
    private Inventory $empty;

    protected function setUp(): void
    {
        $this->inventory = new Inventory([
            'KB-100' => new Product('Keyboard', 49.90, 12),
            'MS-200' => new Product('Mouse', 19.90, 0),
            'MN-300' => new Product('Monitor', 279.00, 3),
            'MS-210' => new Product('Trackball', 89.00, 0, discontinued: true),
            'MN-310' => new Product('Ultrawide monitor', 649.00, 1),
        ]);
        $this->healthy = new Inventory([
            'KB-100' => new Product('Keyboard', 49.90, 12),
            'MN-300' => new Product('Monitor', 279.00, 3),
        ]);
        $this->empty = new Inventory([]);
    }

    public function testFirstSoldOut(): void
    {
        self::assertSame('Mouse', $this->inventory->firstSoldOut()?->name);
        self::assertNull($this->healthy->firstSoldOut());
        self::assertNull($this->empty->firstSoldOut());
    }

    public function testFirstWithSkuPrefix(): void
    {
        self::assertSame('Monitor', $this->inventory->firstWithSkuPrefix('MN-')?->name);
        self::assertSame('Trackball', $this->inventory->firstWithSkuPrefix('MS-21')?->name);
        self::assertNull($this->inventory->firstWithSkuPrefix('XX-'));
    }

    public function testSkuOfFirstPricedAbove(): void
    {
        self::assertSame('MN-300', $this->inventory->skuOfFirstPricedAbove(100.0));
        self::assertSame('MN-310', $this->inventory->skuOfFirstPricedAbove(279.0));
        self::assertNull($this->inventory->skuOfFirstPricedAbove(1000.0));
        self::assertNull($this->empty->skuOfFirstPricedAbove(0.0));
    }

    public function testHasDiscontinued(): void
    {
        self::assertTrue($this->inventory->hasDiscontinued());
        self::assertFalse($this->healthy->hasDiscontinued());
        self::assertFalse($this->empty->hasDiscontinued());
    }

    public function testIsFullyStocked(): void
    {
        self::assertFalse($this->inventory->isFullyStocked());
        self::assertTrue($this->healthy->isFullyStocked());
        self::assertTrue($this->empty->isFullyStocked());
    }

    /** @return iterable<string, array{string}> */
    public static function forbidden(): iterable
    {
        yield 'foreach' => ['foreach'];
        yield 'for' => ['for'];
        yield 'while' => ['while'];
        yield 'array_filter' => ['array_filter'];
    }

    #[DataProvider('forbidden')]
    public function testItDoesNotUse(string $token): void
    {
        self::assertSame(0, Source::ofClass(Inventory::class)->count($token), "Do not use $token.");
    }

    /** @return iterable<string, array{string}> */
    public static function required(): iterable
    {
        yield 'array_find' => ['array_find'];
        yield 'array_find_key' => ['array_find_key'];
        yield 'array_any' => ['array_any'];
        yield 'array_all' => ['array_all'];
    }

    #[DataProvider('required')]
    public function testItUses(string $function): void
    {
        self::assertGreaterThanOrEqual(
            1,
            Source::ofClass(Inventory::class)->countCalls($function),
            "Use $function() at least once.",
        );
    }
}

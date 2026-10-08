<?php

declare(strict_types=1);

namespace Workshop\Ex08ClosuresInConstExpr;

use Closure;
use InvalidArgumentException;

final class TextFilters
{
    public const array FILTERS = [
        'trim' => trim(...),
        'upper' => mb_strtoupper(...),
        'lower' => mb_strtolower(...),
        'snake' => static function (string $text): string {
            return preg_replace('/\s+/', '_', mb_strtolower($text));
        },
    ];

    public static function apply(string $text, string ...$filterNames): string
    {
        foreach ($filterNames as $name) {
            $filter = self::FILTERS[$name] ?? throw new InvalidArgumentException("Unknown filter: $name");
            $text = $filter($text);
        }

        return $text;
    }

    public static function shout(string $text, Closure $transform = mb_strtoupper(...)): string
    {
        return $transform($text) . '!';
    }
}

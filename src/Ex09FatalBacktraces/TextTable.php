<?php

declare(strict_types=1);

namespace Workshop\Ex09FatalBacktraces;

/**
 * Part of EXERCISE 09. Given code: do not change this class.
 */
final class TextTable
{
    /** @param list<int> $widths */
    public static function separator(array $widths): string
    {
        return '+-' . implode('-+-', array_map(self::line(...), $widths)) . '-+';
    }

    /**
     * @param list<string|int|float> $cells
     * @param list<int> $widths
     */
    public static function row(array $cells, array $widths): string
    {
        return '| ' . implode(' | ', array_map(self::pad(...), $cells, $widths)) . ' |';
    }

    private static function line(int $width): string
    {
        return str_repeat('-', $width);
    }

    private static function pad(string|int|float $cell, int $width): string
    {
        $text = (string) $cell;

        return $text . str_repeat(' ', max(0, $width - mb_strlen($text)));
    }
}

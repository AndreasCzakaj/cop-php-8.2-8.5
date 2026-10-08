<?php

declare(strict_types=1);

namespace Workshop\Ex09FatalBacktraces;

final class ColumnLayout
{
    /**
     * The width of every column: wide enough for its header and all its cells.
     *
     * @param list<string> $header
     * @param list<list<string|int|float>> $rows
     * @return list<int>
     */
    public static function widths(array $header, array $rows): array
    {
        $widths = array_map(self::cellWidth(...), $header);

        foreach ($rows as $row) {
            foreach ($row as $column => $cell) {
                $widths[$column] = max($widths[$column], self::cellWidth($cell));
            }
        }

        return $widths;
    }

    private static function cellWidth(string|int|float $cell): int
    {
        // numbers need as much room as they have digits
        return mb_strlen((string) $cell);
    }
}

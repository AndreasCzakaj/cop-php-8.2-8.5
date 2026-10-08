<?php

declare(strict_types=1);

namespace Workshop\Ex09FatalBacktraces;

/**
 * Part of EXERCISE 09, see run-reports.php for the task.
 */
final readonly class Report
{
    /**
     * @param list<string> $header
     * @param list<list<string|int|float>> $rows
     */
    public function __construct(
        private string $title,
        private array $header,
        private array $rows,
    ) {
    }

    public function render(): string
    {
        $widths = ColumnLayout::widths($this->header, $this->rows);
        $separator = TextTable::separator($widths);

        $lines = [$this->title, $separator, TextTable::row($this->header, $widths), $separator];
        foreach ($this->rows as $row) {
            $lines[] = TextTable::row($row, $widths);
        }
        $lines[] = $separator;

        return implode(PHP_EOL, $lines) . PHP_EOL;
    }
}

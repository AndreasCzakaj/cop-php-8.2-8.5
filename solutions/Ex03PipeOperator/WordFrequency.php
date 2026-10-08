<?php

declare(strict_types=1);

namespace Workshop\Ex03PipeOperator;

final class WordFrequency
{
    /** @return array<string, int> */
    public static function top(string $text, int $limit): array
    {
        return $text
            |> mb_strtolower(...)
            |> (static fn (string $s): array => preg_split('/[^\p{L}]+/u', $s, -1, PREG_SPLIT_NO_EMPTY))
            |> array_count_values(...)
            |> self::mostFrequentFirst(...)
            |> (static fn (array $counts): array => array_slice($counts, 0, $limit, true));
    }

    /**
     * @param array<string, int> $counts
     * @return array<string, int>
     */
    private static function mostFrequentFirst(array $counts): array
    {
        ksort($counts, SORT_STRING);
        arsort($counts);

        return $counts;
    }
}

<?php

declare(strict_types=1);

namespace Workshop\Ex03PipeOperator;

/**
 * EXERCISE 03 / TASK 2: Pipe operator - build a data pipeline
 * (PHP 8.5)
 *
 * PROBLEM
 *   For a tag cloud we need the most frequent words of a text.
 *
 * TASK
 *   Implement top(): it returns the $limit most frequent words as
 *   [word => count], most frequent first. Words with the same count are
 *   ordered alphabetically.
 *
 *     top('The cat and the hat', 2)  =>  ['the' => 2, 'and' => 1]
 *
 *   - Words are compared case-insensitively and returned in lower case.
 *   - A word is a run of letters; everything else (spaces, digits,
 *     punctuation) separates words. Umlauts are letters.
 *
 * CONSTRAINTS
 *   - top() is a single return statement: one pipe chain with at least four |>.
 *   - No temporary variables in top(). Helper methods are allowed.
 *
 * HINTS
 *   - preg_split('/[^\p{L}]+/u', $text, -1, PREG_SPLIT_NO_EMPTY)
 *   - array_count_values(), array_slice() with $preserve_keys
 *   - Careful: ksort() and arsort() take their array BY REFERENCE and return
 *     a bool, so they cannot be a pipe step directly. How do you get around
 *     that? (arsort() is stable: equal counts keep their previous order.)
 *   - Methods work as steps as well: |> self::helper(...)
 *
 * VERIFY
 *   make test ex=03
 */
final class WordFrequency
{
    /** @return array<string, int> */
    public static function top(string $text, int $limit): array
    {
        throw new \LogicException('TODO: implement ' . __METHOD__);
    }
}

<?php

declare(strict_types=1);

namespace Workshop\Ex03PipeOperator;

/**
 * EXERCISE 03 / TASK 1: Pipe operator - untangle nested calls
 * (PHP 8.5)
 *
 * PROBLEM
 *   slugify() works, but it has to be read from the inside out: the first
 *   step is in the middle of the line and the last one at both ends.
 *
 * TASK
 *   Rewrite slugify() as one pipe chain that reads top to bottom in the
 *   order in which the steps happen. The behaviour must stay the same.
 *
 * CONSTRAINTS
 *   - The method body is a single return statement.
 *   - Use the pipe operator |> at least four times.
 *   - No temporary variables.
 *
 * HINTS
 *   - The right-hand side of |> is a callable that takes ONE argument:
 *       $title |> trim(...) |> mb_strtolower(...)
 *   - For functions that need more arguments, wrap the call in an arrow
 *     function. The parentheses around it are mandatory:
 *       |> (fn (string $s) => strtr($s, self::TRANSLITERATION))
 *
 * VERIFY
 *   make test ex=03
 */
final class Slugger
{
    private const array TRANSLITERATION = ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss'];

    public static function slugify(string $title): string
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtr(mb_strtolower(trim($title)), self::TRANSLITERATION)), '-');
    }
}

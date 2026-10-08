<?php

declare(strict_types=1);

namespace Workshop\Ex08ClosuresInConstExpr;

use Closure;

/**
 * EXERCISE 08 / TASK 2: Closures in constants and default values
 * (PHP 8.5, builds on typed class constants from PHP 8.3)
 *
 * PROBLEM
 *   A template engine offers named text filters: {{ title | trim | snake }}.
 *   The natural place for the list of filters is a constant that maps names
 *   to callables. Before PHP 8.5 a constant could not hold a callable, so
 *   such lists ended up as strings ('strtoupper'), in static properties or
 *   in a long match expression.
 *
 * TASK
 *   1. Fill the constant FILTERS with these four filters:
 *        'trim'   removes surrounding whitespace             trim()
 *        'upper'  converts to upper case                     mb_strtoupper()
 *        'lower'  converts to lower case                     mb_strtolower()
 *        'snake'  lower case, runs of whitespace become "_"  ('Hello  World' => 'hello_world')
 *   2. Implement apply(): it runs the text through the named filters from
 *      left to right. An unknown name throws an \InvalidArgumentException.
 *   3. Give the parameter $transform of shout() a default value so that
 *      shout('hi') returns 'HI!'.
 *
 * CONSTRAINTS
 *   - 'trim', 'upper' and 'lower' are first-class callables such as trim(...).
 *   - 'snake' is a closure written directly in the constant.
 *   - apply() looks the filters up in the constant: no match, no switch.
 *   - The default value of $transform is a callable, not null.
 *
 * HINTS
 *   - To call a closure stored in a constant: (self::FILTERS[$name])($text)
 *   - preg_replace('/\s+/', '_', $text)
 *
 * VERIFY
 *   make test ex=08
 */
final class TextFilters
{
    public const array FILTERS = [
        // TODO
    ];

    public static function apply(string $text, string ...$filterNames): string
    {
        throw new \LogicException('TODO: implement ' . __METHOD__);
    }

    // TODO: add the default value
    public static function shout(string $text, Closure $transform): string
    {
        return $transform($text) . '!';
    }
}

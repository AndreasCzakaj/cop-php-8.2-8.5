<?php

declare(strict_types=1);

namespace Workshop\Ex07ArrayFirstLast;

/**
 * EXERCISE 07: array_first() and array_last()
 * (PHP 8.5)
 *
 * PROBLEM
 *   Getting the first or last VALUE of an array has always been awkward:
 *   reset() and end() move the internal pointer and return false for an
 *   empty array, $array[0] only works if the keys happen to start at 0, and
 *   array_key_first()/array_key_last() need a second step. This class shows
 *   all of these idioms, and one of them hides a bug:
 *
 *     make test ex=07
 *
 * TASK
 *   Rewrite the four methods with array_first() and array_last(). All of
 *   them return the name of a driver, or null if there is none.
 *
 * CONSTRAINTS
 *   - Use array_first() and array_last(), each at least once.
 *   - Do not use reset, end, current, count, array_values, array_slice,
 *     array_pop, array_shift, array_key_first or array_key_last.
 *
 * HINTS
 *   - Both functions return null for an empty array.
 *   - Reading an offset of null is allowed and gives null: null['driver'].
 *   - Bonus: write worstOfTeam() as a pipe chain (exercise 03).
 *
 * VERIFY
 *   make test ex=07
 */
final class RaceResults
{
    /** @param list<array{driver: string, team: string}> $finishers in finishing order, winner first */
    public function __construct(private array $finishers)
    {
    }

    public function winner(): ?string
    {
        $finishers = $this->finishers;
        $first = reset($finishers);

        return $first === false ? null : $first['driver'];
    }

    public function lastFinisher(): ?string
    {
        if ($this->finishers === []) {
            return null;
        }

        return $this->finishers[array_key_last($this->finishers)]['driver'];
    }

    /** The best placed driver of the team. */
    public function bestOfTeam(string $team): ?string
    {
        $ofTeam = array_values(array_filter($this->finishers, fn (array $f) => $f['team'] === $team));

        return $ofTeam[0]['driver'] ?? null;
    }

    /** The worst placed driver of the team. */
    public function worstOfTeam(string $team): ?string
    {
        $ofTeam = array_filter($this->finishers, fn (array $f) => $f['team'] === $team);

        return $ofTeam[count($ofTeam) - 1]['driver'] ?? null;
    }
}

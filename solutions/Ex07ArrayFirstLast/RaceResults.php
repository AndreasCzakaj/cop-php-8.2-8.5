<?php

declare(strict_types=1);

namespace Workshop\Ex07ArrayFirstLast;

final class RaceResults
{
    /** @param list<array{driver: string, team: string}> $finishers in finishing order, winner first */
    public function __construct(private array $finishers)
    {
    }

    public function winner(): ?string
    {
        return array_first($this->finishers)['driver'] ?? null;
    }

    public function lastFinisher(): ?string
    {
        return array_last($this->finishers)['driver'] ?? null;
    }

    public function bestOfTeam(string $team): ?string
    {
        return array_first($this->ofTeam($team))['driver'] ?? null;
    }

    public function worstOfTeam(string $team): ?string
    {
        return $this->ofTeam($team)
            |> array_last(...)
            |> (static fn (?array $finisher): ?string => $finisher['driver'] ?? null);
    }

    /** @return array<int, array{driver: string, team: string}> */
    private function ofTeam(string $team): array
    {
        return array_filter($this->finishers, static fn (array $finisher): bool => $finisher['team'] === $team);
    }
}

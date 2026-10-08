<?php

declare(strict_types=1);

namespace Workshop\Ex03PipeOperator;

final class Slugger
{
    private const array TRANSLITERATION = ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss'];

    public static function slugify(string $title): string
    {
        return $title
            |> trim(...)
            |> mb_strtolower(...)
            |> (static fn (string $s): string => strtr($s, self::TRANSLITERATION))
            |> (static fn (string $s): string => preg_replace('/[^a-z0-9]+/', '-', $s))
            |> (static fn (string $s): string => trim($s, '-'));
    }
}

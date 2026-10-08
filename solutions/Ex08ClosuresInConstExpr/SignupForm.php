<?php

declare(strict_types=1);

namespace Workshop\Ex08ClosuresInConstExpr;

final class SignupForm
{
    #[Rule(static function (string $value): bool {
        return trim($value) !== '';
    }, 'Username must not be empty')]
    #[Rule(ctype_alnum(...), 'Username must be alphanumeric')]
    public string $username;

    #[Rule(static function (string $value): bool {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }, 'Email is invalid')]
    public string $email;

    #[Rule(static function (int $value): bool {
        return $value >= 18;
    }, 'Must be at least 18')]
    public int $age;

    public function __construct(string $username, string $email, int $age)
    {
        $this->username = $username;
        $this->email = $email;
        $this->age = $age;
    }
}

<?php

declare(strict_types=1);

namespace Workshop\Ex01PropertyHooks;

use InvalidArgumentException;

final class User
{
    public string $email {
        set(string $value) {
            $value = strtolower(trim($value));

            if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
                throw new InvalidArgumentException("Invalid email address: $value");
            }

            $this->email = $value;
        }
    }

    public string $fullName {
        get => "$this->firstName $this->lastName";
    }

    public function __construct(
        public string $firstName,
        public string $lastName,
        string $email,
    ) {
        $this->email = $email;
    }
}

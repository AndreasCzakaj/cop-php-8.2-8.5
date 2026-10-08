<?php

declare(strict_types=1);

namespace Workshop\Ex08ClosuresInConstExpr;

/**
 * EXERCISE 08 / TASK 1: Closures in constant expressions - rules in attributes
 * (PHP 8.5)
 *
 * PROBLEM
 *   Attribute arguments must be constant expressions. Until PHP 8.5 that
 *   excluded closures, so validation libraries had to invent one attribute
 *   class per rule (#[NotBlank], #[Email], #[Min(18)], ...) or pass method
 *   names as strings. Now the logic can be written where it is used.
 *
 * TASK
 *   Rule and Validator are given. Add #[Rule(...)] attributes to the three
 *   properties so that Validator::validate() reports these messages:
 *
 *   username
 *     'Username must not be empty'      if it is empty after trimming
 *     'Username must be alphanumeric'   if it has other characters than
 *                                       letters and digits
 *     (in this order; an empty username breaks both rules)
 *   email
 *     'Email is invalid'                if it is not a valid email address
 *   age
 *     'Must be at least 18'             if it is below 18
 *
 * CONSTRAINTS
 *   - Do not change Rule, Validator or the constructor.
 *   - Do not add methods or functions: all logic lives in the attributes.
 *   - The alphanumeric rule is the first-class callable ctype_alnum(...).
 *
 * HINTS
 *   - #[Rule(static function (string $value): bool { return ...; }, 'Message')]
 *   - A closure in a constant expression must be "static" and cannot use
 *     variables from the outside (no "use", and therefore no arrow functions).
 *   - filter_var($value, FILTER_VALIDATE_EMAIL) returns false if invalid.
 *
 * VERIFY
 *   make test ex=08
 */
final class SignupForm
{
    // TODO: add the rules
    public string $username;

    // TODO: add the rule
    public string $email;

    // TODO: add the rule
    public int $age;

    public function __construct(string $username, string $email, int $age)
    {
        $this->username = $username;
        $this->email = $email;
        $this->age = $age;
    }
}

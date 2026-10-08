<?php

declare(strict_types=1);

namespace Workshop\Ex01PropertyHooks;

/**
 * EXERCISE 01 / TASK 1: Property hooks - a user without getters and setters
 * (PHP 8.4)
 *
 * PROBLEM
 *   Until now a property that needs validation or a computed value forced us
 *   to write getX()/setX() methods. With property hooks the logic lives on
 *   the property itself and callers simply write $user->email = '...'.
 *
 * TASK
 *   Give this class four public properties:
 *
 *   - firstName, lastName (string)
 *       Plain properties, readable and writable.
 *
 *   - email (string)
 *       Every write is normalised: surrounding whitespace is removed and the
 *       address is lower-cased. A write of an invalid address throws an
 *       \InvalidArgumentException. This also applies to the value passed to
 *       the constructor.
 *
 *   - fullName (string)
 *       Computed from firstName and lastName ("Ada Lovelace"). It always
 *       reflects the current names and cannot be written.
 *
 * CONSTRAINTS
 *   - Use property hooks. The class must have no methods besides __construct.
 *   - fullName must be a virtual property, i.e. it stores no value of its own.
 *
 * HINTS
 *   - filter_var($value, FILTER_VALIDATE_EMAIL)
 *   - A property whose hooks never touch $this->propertyName is virtual.
 *   - A virtual property without a set hook is read-only automatically.
 *
 * VERIFY
 *   make test ex=01
 */
final class User
{
    // TODO: declare the properties and their hooks

    public function __construct(string $firstName, string $lastName, string $email)
    {
        // TODO
    }
}

<?php

declare(strict_types=1);

namespace Workshop\Ex01PropertyHooks;

/**
 * EXERCISE 01 / TASK 2: Property hooks - properties in interfaces
 * (PHP 8.4)
 *
 * PROBLEM
 *   Interfaces could only demand methods, so every implementation needed a
 *   getArea() method even if the value was a simple property. Since PHP 8.4
 *   an interface can demand a readable (and/or writable) property.
 *
 * TASK
 *   1. In this interface, demand a publicly readable float property "area".
 *   2. Implement it in Square.php and Circle.php (see the instructions there).
 *
 * CONSTRAINTS
 *   - The interface must not declare any methods.
 *
 * VERIFY
 *   make test ex=01
 */
interface Shape
{
    // TODO
}

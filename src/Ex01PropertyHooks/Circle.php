<?php

declare(strict_types=1);

namespace Workshop\Ex01PropertyHooks;

/**
 * EXERCISE 01 / TASK 2 (continued)
 *
 * TASK
 *   A circle has three public float properties:
 *
 *   - radius    Writable. A negative value throws an \InvalidArgumentException,
 *               in the constructor as well as later on.
 *   - area      Readable only: pi * radius^2 (use M_PI).
 *   - diameter  Readable AND writable, but without a value of its own:
 *               reading returns 2 * radius, writing changes the radius.
 *               A negative diameter is rejected like a negative radius.
 *
 * CONSTRAINTS
 *   - No methods besides __construct.
 *   - "area" and "diameter" must be virtual properties.
 *   - Write the validation only once.
 *
 * HINTS
 *   - A set hook of a virtual property may assign to another property, which
 *     in turn runs that property's set hook.
 */
final class Circle implements Shape
{
    public function __construct(float $radius)
    {
        // TODO
    }
}

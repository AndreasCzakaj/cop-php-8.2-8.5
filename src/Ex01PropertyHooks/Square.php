<?php

declare(strict_types=1);

namespace Workshop\Ex01PropertyHooks;

/**
 * EXERCISE 01 / TASK 2 (continued)
 *
 * TASK
 *   A square has a writable float property "side" and the "area" demanded by
 *   Shape (side * side). The area follows every change of the side.
 *
 * CONSTRAINTS
 *   - No methods besides __construct.
 *   - "area" must be a virtual property.
 */
final class Square implements Shape
{
    public function __construct(float $side)
    {
        // TODO
    }
}

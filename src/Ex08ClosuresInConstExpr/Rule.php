<?php

declare(strict_types=1);

namespace Workshop\Ex08ClosuresInConstExpr;

use Attribute;
use Closure;

/**
 * Part of EXERCISE 08 / TASK 1. Given code: do not change this class.
 *
 * A validation rule for a property: $check receives the value of the property
 * and returns true if it is valid. $message is reported otherwise.
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
final readonly class Rule
{
    public function __construct(
        public Closure $check,
        public string $message,
    ) {
    }
}

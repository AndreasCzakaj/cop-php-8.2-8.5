<?php

declare(strict_types=1);

namespace Workshop\Ex08ClosuresInConstExpr;

use ReflectionObject;

/**
 * Part of EXERCISE 08 / TASK 1. Given code: do not change this class.
 */
final class Validator
{
    /**
     * Checks all #[Rule] attributes of the object's properties.
     *
     * @return array<string, list<string>> the messages of the broken rules by property name
     */
    public static function validate(object $subject): array
    {
        $errors = [];

        foreach (new ReflectionObject($subject)->getProperties() as $property) {
            foreach ($property->getAttributes(Rule::class) as $attribute) {
                $rule = $attribute->newInstance();

                if (!($rule->check)($property->getValue($subject))) {
                    $errors[$property->getName()][] = $rule->message;
                }
            }
        }

        return $errors;
    }
}

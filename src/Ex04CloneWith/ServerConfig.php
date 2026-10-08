<?php

declare(strict_types=1);

namespace Workshop\Ex04CloneWith;

/**
 * EXERCISE 04 / TASK 2: clone with - from outside the class
 * (PHP 8.5, builds on asymmetric visibility from PHP 8.4)
 *
 * PROBLEM
 *   A plain configuration object should not need one with*() method per
 *   property. Callers should be able to derive a variant themselves:
 *
 *     $staging = clone($production, ['host' => 'staging.example.com']);
 *
 *   Right now that line fails. Run the tests and read the error message.
 *
 * TASK
 *   1. Change this class so that clone() with new values works from outside
 *      the class for all three properties.
 *   2. Implement Deployment::staging() in Deployment.php.
 *
 * CONSTRAINTS
 *   - The class stays "final readonly": $config->port = 8080 must still fail.
 *   - Do not add any methods.
 *
 * HINTS
 *   - A readonly property is implicitly protected(set).
 *
 * TO DISCUSS
 *   - Nothing stops clone($config, ['port' => -1]) now. Readonly properties
 *     cannot have hooks. How would you design a config that can be cloned
 *     from outside AND validates its values?
 *
 * VERIFY
 *   make test ex=04
 */
final readonly class ServerConfig
{
    public function __construct(
        public string $host,
        public int $port = 443,
        public bool $tls = true,
    ) {
    }
}

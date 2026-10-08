<?php

declare(strict_types=1);

namespace Workshop\Ex04CloneWith;

/**
 * EXERCISE 04 / TASK 2 (continued)
 *
 * TASK
 *   staging() derives the staging configuration from the production one:
 *   - the host gets the prefix "staging." (example.com => staging.example.com)
 *   - the port is 8443
 *   - everything else stays as it is
 *
 * CONSTRAINTS
 *   - Use clone() with the second argument, do not call "new ServerConfig".
 */
final class Deployment
{
    public static function staging(ServerConfig $production): ServerConfig
    {
        throw new \LogicException('TODO: implement ' . __METHOD__);
    }
}

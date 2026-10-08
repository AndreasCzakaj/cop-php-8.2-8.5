<?php

declare(strict_types=1);

namespace Workshop\Ex04CloneWith;

final class Deployment
{
    public static function staging(ServerConfig $production): ServerConfig
    {
        return clone($production, [
            'host' => "staging.$production->host",
            'port' => 8443,
        ]);
    }
}

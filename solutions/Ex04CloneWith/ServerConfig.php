<?php

declare(strict_types=1);

namespace Workshop\Ex04CloneWith;

final readonly class ServerConfig
{
    public function __construct(
        public(set) string $host,
        public(set) int $port = 443,
        public(set) bool $tls = true,
    ) {
    }
}

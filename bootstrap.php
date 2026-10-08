<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

// With WORKSHOP_SOLUTIONS=1 the classes in solutions/ take precedence over
// their counterparts in src/. Files that have no solution fall back to src/.
if (getenv('WORKSHOP_SOLUTIONS')) {
    spl_autoload_register(static function (string $class): void {
        if (!str_starts_with($class, 'Workshop\\')) {
            return;
        }

        $file = __DIR__ . '/solutions/' . str_replace('\\', '/', substr($class, 9)) . '.php';
        if (is_file($file)) {
            require $file;
        }
    }, prepend: true);
}

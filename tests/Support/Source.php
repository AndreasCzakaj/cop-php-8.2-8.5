<?php

declare(strict_types=1);

namespace Workshop\Tests\Support;

use PhpToken;
use ReflectionClass;

/**
 * Looks at the source code of a class so that the tests can check HOW a task
 * was solved (e.g. "uses the pipe operator"), not only that it works.
 * Comments and whitespace are ignored.
 */
final class Source
{
    /** @var list<string> lower-cased token texts */
    private array $tokens = [];

    private function __construct(string $file)
    {
        foreach (PhpToken::tokenize((string) file_get_contents($file)) as $token) {
            if (!$token->isIgnorable()) {
                $this->tokens[] = ltrim(strtolower($token->text), '\\');
            }
        }
    }

    /** @param class-string $class */
    public static function ofClass(string $class): self
    {
        return new self((string) new ReflectionClass($class)->getFileName());
    }

    /** Number of occurrences of a token such as "|>", "foreach" or "clone". */
    public function count(string $token): int
    {
        return count(array_keys($this->tokens, strtolower($token), true));
    }

    /** Number of occurrences of consecutive tokens, e.g. ("new", "self"). */
    public function countSequence(string ...$sequence): int
    {
        $sequence = array_map(strtolower(...), $sequence);
        $length = count($sequence);
        $hits = 0;

        for ($i = 0; $i <= count($this->tokens) - $length; $i++) {
            if (array_slice($this->tokens, $i, $length) === $sequence) {
                $hits++;
            }
        }

        return $hits;
    }

    /** Number of calls of a function, first-class callable syntax included. */
    public function countCalls(string $function): int
    {
        return $this->countSequence($function, '(');
    }
}

<?php

declare(strict_types=1);

namespace Workshop\Ex02AsymmetricVisibility;

use InvalidArgumentException;

class Document
{
    public string $title {
        set(string $value) {
            $value = trim($value);

            if ($value === '') {
                throw new InvalidArgumentException('The title must not be empty.');
            }

            if (isset($this->title) && $this->title !== $value) {
                $this->revision++;
            }

            $this->title = $value;
        }
    }

    public private(set) int $revision = 0;

    public protected(set) string $status = 'draft';

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function publish(): void
    {
        $this->status = 'published';
    }
}

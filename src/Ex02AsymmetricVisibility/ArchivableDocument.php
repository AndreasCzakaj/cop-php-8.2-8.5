<?php

declare(strict_types=1);

namespace Workshop\Ex02AsymmetricVisibility;

/**
 * Part of EXERCISE 02 / TASK 2. Given code: do not change this class.
 */
final class ArchivableDocument extends Document
{
    public function archive(): void
    {
        $this->status = 'archived';
    }
}

<?php

declare(strict_types=1);

namespace Workshop\Ex02AsymmetricVisibility;

/**
 * EXERCISE 02 / TASK 2: Asymmetric visibility meets property hooks
 * (PHP 8.4)
 *
 * PROBLEM
 *   A document keeps track of how often its title was changed and of its
 *   status. Callers may change the title freely, but the bookkeeping must be
 *   tamper-proof. ArchivableDocument (already written, do not change it) is
 *   a subclass that sets the status itself.
 *
 * TASK
 *   Implement these public members:
 *
 *   - title (string)     Readable and writable from everywhere. Every write
 *                        is trimmed; an empty title throws an
 *                        \InvalidArgumentException.
 *   - revision (int)     Starts at 0 and goes up by 1 whenever the title
 *                        changes to a DIFFERENT value. The initial title from
 *                        the constructor does not count. Writable only inside
 *                        this class, not even in subclasses.
 *   - status (string)    Starts as 'draft'. Readable from everywhere, writable
 *                        inside this class and its subclasses only.
 *   - publish()          Sets the status to 'published'.
 *
 * CONSTRAINTS
 *   - No getter or setter methods: __construct and publish are the only ones.
 *   - Do not change ArchivableDocument.
 *
 * HINTS
 *   - There are three set-visibilities: public(set), protected(set), private(set).
 *   - Inside a set hook, isset($this->title) tells you whether the property
 *     has been initialised yet.
 *
 * VERIFY
 *   make test ex=02
 */
class Document
{
    // TODO: declare the properties

    public function __construct(string $title)
    {
        // TODO
    }

    public function publish(): void
    {
        throw new \LogicException('TODO: implement ' . __METHOD__);
    }
}

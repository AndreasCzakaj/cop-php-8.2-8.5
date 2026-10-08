<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex02AsymmetricVisibility;

use Error;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use Workshop\Ex02AsymmetricVisibility\ArchivableDocument;
use Workshop\Ex02AsymmetricVisibility\Document;

final class DocumentTest extends TestCase
{
    public function testANewDocumentIsAnUnrevisedDraft(): void
    {
        $document = new Document('  Release notes ');

        self::assertSame('Release notes', $document->title);
        self::assertSame(0, $document->revision);
        self::assertSame('draft', $document->status);
    }

    public function testChangingTheTitleBumpsTheRevision(): void
    {
        $document = new Document('Release notes');
        $document->title = 'Release notes 8.5';
        $document->title = ' Changelog ';

        self::assertSame('Changelog', $document->title);
        self::assertSame(2, $document->revision);
    }

    public function testWritingTheSameTitleDoesNotBumpTheRevision(): void
    {
        $document = new Document('Release notes');
        $document->title = 'Release notes';
        $document->title = '  Release notes  ';

        self::assertSame(0, $document->revision);
    }

    public function testAnEmptyTitleIsRejected(): void
    {
        $document = new Document('Release notes');

        try {
            $document->title = "  \n ";
            self::fail('An empty title must throw an InvalidArgumentException.');
        } catch (InvalidArgumentException) {
            self::assertSame('Release notes', $document->title);
            self::assertSame(0, $document->revision);
        }
    }

    public function testAnEmptyTitleIsRejectedInTheConstructor(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Document('');
    }

    public function testPublishing(): void
    {
        $document = new Document('Release notes');
        $document->publish();

        self::assertSame('published', $document->status);
    }

    public function testASubclassMaySetTheStatus(): void
    {
        $document = new ArchivableDocument('Release notes');
        $document->archive();

        self::assertSame('archived', $document->status);
    }

    public function testTheRevisionCannotBeWrittenFromOutside(): void
    {
        $document = new Document('Release notes');

        $this->expectException(Error::class);
        $document->revision = 42;
    }

    public function testTheStatusCannotBeWrittenFromOutside(): void
    {
        $document = new Document('Release notes');

        $this->expectException(Error::class);
        $document->status = 'published';
    }

    public function testTheSetVisibilities(): void
    {
        $class = new ReflectionClass(Document::class);
        foreach (['title', 'revision', 'status'] as $name) {
            self::assertTrue($class->hasProperty($name), "Missing property $name.");
            self::assertTrue($class->getProperty($name)->isPublic(), "$name must be publicly readable.");
        }

        self::assertTrue($class->getProperty('revision')->isPrivateSet(), 'revision must be private(set).');
        self::assertTrue($class->getProperty('status')->isProtectedSet(), 'status must be protected(set).');
        self::assertTrue($class->getProperty('title')->hasHooks(), 'title needs a set hook.');
    }

    public function testThereAreNoGettersOrSetters(): void
    {
        $methods = array_map(
            static fn ($method) => $method->getName(),
            new ReflectionClass(Document::class)->getMethods(ReflectionMethod::IS_PUBLIC),
        );
        sort($methods);

        self::assertSame(['__construct', 'publish'], $methods);
    }
}

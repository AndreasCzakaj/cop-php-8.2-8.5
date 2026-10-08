<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex04CloneWith;

use Error;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Workshop\Ex04CloneWith\Deployment;
use Workshop\Ex04CloneWith\ServerConfig;
use Workshop\Tests\Support\Source;

final class ServerConfigTest extends TestCase
{
    public function testItCanBeClonedWithNewValuesFromOutside(): void
    {
        $production = new ServerConfig('example.com');
        $local = clone($production, ['host' => 'localhost', 'port' => 8080, 'tls' => false]);

        self::assertSame('localhost', $local->host);
        self::assertSame(8080, $local->port);
        self::assertFalse($local->tls);

        self::assertSame('example.com', $production->host, 'The original must not change.');
        self::assertSame(443, $production->port);
        self::assertTrue($production->tls);
    }

    public function testItIsStillImmutable(): void
    {
        $config = new ServerConfig('example.com');

        $this->expectException(Error::class);
        $config->port = 8080;
    }

    public function testACloneIsImmutableAsWell(): void
    {
        $config = clone(new ServerConfig('example.com'), ['port' => 8080]);

        $this->expectException(Error::class);
        $config->port = 9090;
    }

    public function testTheClassStaysFinalReadonlyWithoutMethods(): void
    {
        $class = new ReflectionClass(ServerConfig::class);

        self::assertTrue($class->isReadOnly() && $class->isFinal());
        self::assertCount(1, $class->getMethods(), '__construct must be the only method.');
    }

    public function testStagingIsDerivedFromProduction(): void
    {
        $production = new ServerConfig('example.com', 443, true);
        $staging = Deployment::staging($production);

        self::assertNotSame($production, $staging);
        self::assertSame('staging.example.com', $staging->host);
        self::assertSame(8443, $staging->port);
        self::assertTrue($staging->tls);
        self::assertSame('example.com', $production->host);
    }

    public function testStagingKeepsTheOtherSettings(): void
    {
        $staging = Deployment::staging(new ServerConfig('intranet.local', 80, false));

        self::assertSame('staging.intranet.local', $staging->host);
        self::assertFalse($staging->tls);
    }

    public function testStagingUsesClone(): void
    {
        $source = Source::ofClass(Deployment::class);

        self::assertSame(1, $source->countCalls('clone'), 'Use clone($production, [...]).');
        self::assertSame(0, $source->countSequence('new', 'serverconfig'), 'Do not call the constructor.');
    }
}

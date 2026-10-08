<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex01PropertyHooks;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;
use Workshop\Ex01PropertyHooks\Circle;
use Workshop\Ex01PropertyHooks\Shape;
use Workshop\Ex01PropertyHooks\Square;

final class ShapeTest extends TestCase
{
    public function testTheInterfaceDemandsAPropertyInsteadOfAMethod(): void
    {
        $interface = new ReflectionClass(Shape::class);

        self::assertTrue($interface->hasProperty('area'), 'Shape must declare the property "area".');
        self::assertSame('float', (string) $interface->getProperty('area')->getType());
        self::assertSame([], $interface->getMethods(), 'Shape must not declare methods.');
    }

    public function testSquareAreaFollowsTheSide(): void
    {
        $square = new Square(3.0);
        self::assertSame(9.0, $square->area);

        $square->side = 4.0;
        self::assertSame(16.0, $square->area);
    }

    public function testCircleAreaFollowsTheRadius(): void
    {
        $circle = new Circle(1.0);
        self::assertEqualsWithDelta(M_PI, $circle->area, 1e-9);

        $circle->radius = 2.0;
        self::assertEqualsWithDelta(4 * M_PI, $circle->area, 1e-9);
    }

    public function testDiameterReadsFromAndWritesToTheRadius(): void
    {
        $circle = new Circle(2.0);
        self::assertSame(4.0, $circle->diameter);

        $circle->diameter = 10.0;
        self::assertSame(5.0, $circle->radius);
        self::assertSame(10.0, $circle->diameter);
    }

    public function testNegativeRadiusIsRejectedInTheConstructor(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Circle(-1.0);
    }

    public function testNegativeRadiusIsRejectedOnWrite(): void
    {
        $circle = new Circle(1.0);

        $this->expectException(InvalidArgumentException::class);
        $circle->radius = -0.5;
    }

    public function testNegativeDiameterIsRejected(): void
    {
        $circle = new Circle(1.0);

        $this->expectException(InvalidArgumentException::class);
        $circle->diameter = -2.0;
    }

    /** @return iterable<string, array{class-string, string}> */
    public static function virtualProperties(): iterable
    {
        yield 'Square::$area' => [Square::class, 'area'];
        yield 'Circle::$area' => [Circle::class, 'area'];
        yield 'Circle::$diameter' => [Circle::class, 'diameter'];
    }

    #[DataProvider('virtualProperties')]
    public function testComputedPropertiesAreVirtual(string $class, string $property): void
    {
        self::assertTrue(new ReflectionClass($class)->hasProperty($property), "Missing property $property.");
        self::assertTrue(new ReflectionProperty($class, $property)->isVirtual());
    }

    #[DataProvider('shapeClasses')]
    public function testShapesHaveNoMethodsBesidesTheConstructor(string $class): void
    {
        $methods = array_map(
            static fn ($method) => $method->getName(),
            new ReflectionClass($class)->getMethods(),
        );

        self::assertSame(['__construct'], $methods);
    }

    /** @return iterable<string, array{class-string}> */
    public static function shapeClasses(): iterable
    {
        yield 'Square' => [Square::class];
        yield 'Circle' => [Circle::class];
    }
}

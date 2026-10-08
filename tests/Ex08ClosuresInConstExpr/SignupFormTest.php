<?php

declare(strict_types=1);

namespace Workshop\Tests\Ex08ClosuresInConstExpr;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionFunction;
use ReflectionProperty;
use Workshop\Ex08ClosuresInConstExpr\Rule;
use Workshop\Ex08ClosuresInConstExpr\SignupForm;
use Workshop\Ex08ClosuresInConstExpr\Validator;

final class SignupFormTest extends TestCase
{
    public function testAValidFormHasNoErrors(): void
    {
        self::assertSame([], Validator::validate(new SignupForm('ada1815', 'ada@example.com', 36)));
        self::assertSame([], Validator::validate(new SignupForm('a', 'a@b.de', 18)));
    }

    public function testEveryPropertyHasRules(): void
    {
        foreach (['username' => 2, 'email' => 1, 'age' => 1] as $property => $expected) {
            $rules = new ReflectionProperty(SignupForm::class, $property)->getAttributes(Rule::class);
            self::assertCount($expected, $rules, "Number of rules on $property");
        }
    }

    public function testEmptyUsernameBreaksBothRules(): void
    {
        self::assertSame(
            ['username' => ['Username must not be empty', 'Username must be alphanumeric']],
            Validator::validate(new SignupForm('', 'ada@example.com', 36)),
        );
    }

    public function testUsernameMustBeAlphanumeric(): void
    {
        self::assertSame(
            ['username' => ['Username must be alphanumeric']],
            Validator::validate(new SignupForm('ada lovelace!', 'ada@example.com', 36)),
        );
    }

    public function testBlankUsernameCountsAsEmpty(): void
    {
        self::assertSame(
            ['username' => ['Username must not be empty', 'Username must be alphanumeric']],
            Validator::validate(new SignupForm('   ', 'ada@example.com', 36)),
        );
    }

    public function testEmailMustBeValid(): void
    {
        self::assertSame(
            ['email' => ['Email is invalid']],
            Validator::validate(new SignupForm('ada1815', 'ada(at)example.com', 36)),
        );
    }

    public function testAgeMustBeAtLeast18(): void
    {
        self::assertSame(
            ['age' => ['Must be at least 18']],
            Validator::validate(new SignupForm('ada1815', 'ada@example.com', 17)),
        );
    }

    public function testAllErrorsAreReportedTogether(): void
    {
        self::assertSame(
            [
                'username' => ['Username must be alphanumeric'],
                'email' => ['Email is invalid'],
                'age' => ['Must be at least 18'],
            ],
            Validator::validate(new SignupForm('a-d-a', 'nope', 0)),
        );
    }

    public function testTheAlphanumericRuleIsAFirstClassCallable(): void
    {
        $names = array_map(
            static fn ($attribute) => new ReflectionFunction($attribute->newInstance()->check)->getName(),
            new ReflectionProperty(SignupForm::class, 'username')->getAttributes(Rule::class),
        );

        self::assertContains('ctype_alnum', $names, 'Use ctype_alnum(...) as a rule for the username.');
    }

    public function testAllLogicLivesInTheAttributes(): void
    {
        self::assertCount(1, new ReflectionClass(SignupForm::class)->getMethods(), 'Do not add methods.');
    }
}

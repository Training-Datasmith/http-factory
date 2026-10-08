<?php

declare(strict_types=1);

namespace HttpFactory\Tests\Support;

use PHPUnit\Framework\Assert;
use ReflectionMethod;

trait ReturnTypeAssertion
{
    /**
     * @param object $value
     */
    protected static function assertReturnTypeMatchesReflection(
        ReflectionMethod $method,
        $value,
        string $expectedFqcn
    ): void {
        $returnType = $method->getReturnType();
        Assert::assertNotNull($returnType);
        Assert::assertFalse($returnType->allowsNull());
        Assert::assertTrue($returnType->isBuiltin() === false);
        Assert::assertSame($expectedFqcn, $returnType->getName());
        Assert::assertInstanceOf($expectedFqcn, $value);
    }
}

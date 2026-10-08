<?php

declare(strict_types=1);

namespace HttpFactory\Tests\Support;

use PHPUnit\Framework\Assert;
use ReflectionMethod;
use ReflectionParameter;

trait ParameterSignatureAssertion
{
    protected static function assertParameter(
        ReflectionMethod $method,
        int $position,
        string $name,
        bool $hasType,
        ?string $typeName,
        bool $allowsNull,
        bool $isOptional,
        $defaultValue = null,
        ?bool $isDefaultValueConstant = null,
        ?string $defaultValueConstantName = null
    ): void {
        $parameters = $method->getParameters();
        Assert::assertArrayHasKey($position, $parameters);
        $param = $parameters[$position];
        Assert::assertInstanceOf(ReflectionParameter::class, $param);
        Assert::assertSame($name, $param->getName());
        Assert::assertSame($position, $param->getPosition());
        Assert::assertSame($hasType, $param->hasType());
        if ($hasType) {
            Assert::assertNotNull($param->getType());
            Assert::assertSame($typeName, $param->getType()->getName());
            Assert::assertSame($allowsNull, $param->getType()->allowsNull());
        }
        Assert::assertSame($isOptional, $param->isOptional());
        if ($isOptional) {
            Assert::assertSame($defaultValue, $param->getDefaultValue());
            if ($isDefaultValueConstant !== null) {
                Assert::assertSame($isDefaultValueConstant, $param->isDefaultValueConstant());
                if ($isDefaultValueConstant) {
                    Assert::assertSame($defaultValueConstantName, $param->getDefaultValueConstantName());
                }
            }
        }
        Assert::assertFalse($param->isPassedByReference());
        Assert::assertFalse($param->isVariadic());
    }
}

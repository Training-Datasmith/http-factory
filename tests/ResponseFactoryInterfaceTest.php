<?php

declare(strict_types=1);

namespace HttpFactory\Tests;

use HttpFactory\Tests\Double\ResponseFactoryDouble;
use HttpFactory\Tests\Support\ParameterSignatureAssertion;
use HttpFactory\Tests\Support\ReturnTypeAssertion;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionMethod;

final class ResponseFactoryInterfaceTest extends TestCase
{
    use ParameterSignatureAssertion;
    use ReturnTypeAssertion;

    public function testCreateResponseSignature(): void
    {
        $method = new ReflectionMethod(ResponseFactoryInterface::class, 'createResponse');
        self::assertParameter($method, 0, 'code', true, 'int', false, true, 200);
        self::assertParameter($method, 1, 'reasonPhrase', true, 'string', false, true, '');
        $returnType = $method->getReturnType();
        self::assertNotNull($returnType);
        self::assertSame(ResponseInterface::class, $returnType->getName());
    }

    public function testCreateResponseDocblock(): void
    {
        $doc = (new ReflectionMethod(ResponseFactoryInterface::class, 'createResponse'))->getDocComment();
        self::assertIsString($doc);
        self::assertStringContainsString('MAY use', $doc);
    }

    public function testCreateResponseDefaultsAndExplicitCall(): void
    {
        $factory = new ResponseFactoryDouble();
        $method = new ReflectionMethod(ResponseFactoryInterface::class, 'createResponse');
        self::assertReturnTypeMatchesReflection($method, $factory->createResponse(), ResponseInterface::class);
        self::assertReturnTypeMatchesReflection(
            $method,
            $factory->createResponse(204, 'No Content'),
            ResponseInterface::class
        );
    }
}

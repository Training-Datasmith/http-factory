<?php

declare(strict_types=1);

namespace HttpFactory\Tests;

use HttpFactory\Tests\Double\NullUri;
use HttpFactory\Tests\Double\RequestFactoryDouble;
use HttpFactory\Tests\Support\ParameterSignatureAssertion;
use HttpFactory\Tests\Support\ReturnTypeAssertion;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use ReflectionMethod;

final class RequestFactoryInterfaceTest extends TestCase
{
    use ParameterSignatureAssertion;
    use ReturnTypeAssertion;

    public function testCreateRequestSignature(): void
    {
        $method = new ReflectionMethod(RequestFactoryInterface::class, 'createRequest');
        self::assertParameter($method, 0, 'method', true, 'string', false, false);
        self::assertParameter($method, 1, 'uri', false, null, false, false);
        $returnType = $method->getReturnType();
        self::assertNotNull($returnType);
        self::assertSame(RequestInterface::class, $returnType->getName());
    }

    public function testCreateRequestDocblock(): void
    {
        $doc = (new ReflectionMethod(RequestFactoryInterface::class, 'createRequest'))->getDocComment();
        self::assertIsString($doc);
        self::assertStringContainsString('MUST create a UriInterface', $doc);
    }

    public function testCreateRequestAcceptsStringAndUri(): void
    {
        $factory = new RequestFactoryDouble();
        $method = new ReflectionMethod(RequestFactoryInterface::class, 'createRequest');
        self::assertReturnTypeMatchesReflection($method, $factory->createRequest('GET', '/inbox'), RequestInterface::class);
        self::assertReturnTypeMatchesReflection($method, $factory->createRequest('POST', new NullUri()), RequestInterface::class);
    }
}

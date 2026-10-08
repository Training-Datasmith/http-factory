<?php

declare(strict_types=1);

namespace HttpFactory\Tests;

use HttpFactory\Tests\Double\UriFactoryDouble;
use HttpFactory\Tests\Support\ParameterSignatureAssertion;
use HttpFactory\Tests\Support\ReturnTypeAssertion;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use ReflectionMethod;

final class UriFactoryInterfaceTest extends TestCase
{
    use ParameterSignatureAssertion;
    use ReturnTypeAssertion;

    public function testCreateUriSignature(): void
    {
        $method = new ReflectionMethod(UriFactoryInterface::class, 'createUri');
        self::assertParameter($method, 0, 'uri', true, 'string', false, true, '');
        $returnType = $method->getReturnType();
        self::assertNotNull($returnType);
        self::assertSame(UriInterface::class, $returnType->getName());
    }

    public function testCreateUriDocblock(): void
    {
        $doc = (new ReflectionMethod(UriFactoryInterface::class, 'createUri'))->getDocComment();
        self::assertIsString($doc);
        self::assertStringContainsString('@throws \\InvalidArgumentException', $doc);
        self::assertStringContainsString('If the given URI cannot be parsed', $doc);
    }

    public function testCreateUriDefaultAndExplicit(): void
    {
        $factory = new UriFactoryDouble();
        $method = new ReflectionMethod(UriFactoryInterface::class, 'createUri');
        self::assertReturnTypeMatchesReflection($method, $factory->createUri(), UriInterface::class);
        self::assertReturnTypeMatchesReflection($method, $factory->createUri('/inbox'), UriInterface::class);
    }
}

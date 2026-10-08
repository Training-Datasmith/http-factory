<?php

declare(strict_types=1);

namespace HttpFactory\Tests;

use HttpFactory\Tests\Double\NullUri;
use HttpFactory\Tests\Double\ServerRequestFactoryDouble;
use HttpFactory\Tests\Support\ParameterSignatureAssertion;
use HttpFactory\Tests\Support\ReturnTypeAssertion;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionMethod;

final class ServerRequestFactoryInterfaceTest extends TestCase
{
    use ParameterSignatureAssertion;
    use ReturnTypeAssertion;

    public function testCreateServerRequestSignature(): void
    {
        $method = new ReflectionMethod(ServerRequestFactoryInterface::class, 'createServerRequest');
        self::assertParameter($method, 0, 'method', true, 'string', false, false);
        self::assertParameter($method, 1, 'uri', false, null, false, false);
        self::assertParameter($method, 2, 'serverParams', true, 'array', false, true, []);
        $returnType = $method->getReturnType();
        self::assertNotNull($returnType);
        self::assertSame(ServerRequestInterface::class, $returnType->getName());
    }

    public function testCreateServerRequestDocblock(): void
    {
        $doc = (new ReflectionMethod(ServerRequestFactoryInterface::class, 'createServerRequest'))->getDocComment();
        self::assertIsString($doc);
        self::assertStringContainsString('no parsing/processing', $doc);
        self::assertStringContainsString('MUST create a UriInterface', $doc);
    }

    public function testCreateServerRequestAcceptsStringUriAndServerParams(): void
    {
        $factory = new ServerRequestFactoryDouble();
        $method = new ReflectionMethod(ServerRequestFactoryInterface::class, 'createServerRequest');
        self::assertReturnTypeMatchesReflection(
            $method,
            $factory->createServerRequest('GET', '/inbox'),
            ServerRequestInterface::class
        );
        self::assertReturnTypeMatchesReflection(
            $method,
            $factory->createServerRequest('PUT', new NullUri(), ['REQUEST_METHOD' => 'PUT']),
            ServerRequestInterface::class
        );
    }
}

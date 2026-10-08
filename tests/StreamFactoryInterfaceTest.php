<?php

declare(strict_types=1);

namespace HttpFactory\Tests;

use HttpFactory\Tests\Double\StreamFactoryDouble;
use HttpFactory\Tests\Support\ParameterSignatureAssertion;
use HttpFactory\Tests\Support\ReturnTypeAssertion;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use ReflectionMethod;

final class StreamFactoryInterfaceTest extends TestCase
{
    use ParameterSignatureAssertion;
    use ReturnTypeAssertion;

    public function testCreateStreamSignature(): void
    {
        $method = new ReflectionMethod(StreamFactoryInterface::class, 'createStream');
        self::assertParameter($method, 0, 'content', true, 'string', false, true, '');
        $returnType = $method->getReturnType();
        self::assertNotNull($returnType);
        self::assertFalse($returnType->allowsNull());
        self::assertSame(StreamInterface::class, $returnType->getName());
    }

    public function testCreateStreamDocblock(): void
    {
        $doc = (new ReflectionMethod(StreamFactoryInterface::class, 'createStream'))->getDocComment();
        self::assertIsString($doc);
        self::assertStringContainsString('SHOULD be created with a temporary resource', $doc);
    }

    public function testCreateStreamReturnsDeclaredType(): void
    {
        $factory = new StreamFactoryDouble();
        $method = new ReflectionMethod(StreamFactoryInterface::class, 'createStream');
        self::assertReturnTypeMatchesReflection($method, $factory->createStream(), StreamInterface::class);
        self::assertReturnTypeMatchesReflection($method, $factory->createStream('abc'), StreamInterface::class);
    }

    public function testCreateStreamFromFileSignature(): void
    {
        $method = new ReflectionMethod(StreamFactoryInterface::class, 'createStreamFromFile');
        self::assertParameter($method, 0, 'filename', true, 'string', false, false);
        self::assertParameter($method, 1, 'mode', true, 'string', false, true, 'r');
    }

    public function testCreateStreamFromFileDocblock(): void
    {
        $doc = (new ReflectionMethod(StreamFactoryInterface::class, 'createStreamFromFile'))->getDocComment();
        self::assertIsString($doc);
        self::assertStringContainsString('MUST be opened using the given mode', $doc);
        self::assertStringContainsString('@throws \\RuntimeException', $doc);
        self::assertStringContainsString('If the file cannot be opened', $doc);
        self::assertStringContainsString('@throws \\InvalidArgumentException', $doc);
        self::assertStringContainsString('If the mode is invalid', $doc);
    }

    public function testCreateStreamFromFileReturnsDeclaredType(): void
    {
        $method = new ReflectionMethod(StreamFactoryInterface::class, 'createStreamFromFile');
        $factory = new StreamFactoryDouble();
        self::assertReturnTypeMatchesReflection(
            $method,
            $factory->createStreamFromFile('/not/opened/by/this/package', 'r'),
            StreamInterface::class
        );
    }

    public function testCreateStreamFromResourceSignature(): void
    {
        $method = new ReflectionMethod(StreamFactoryInterface::class, 'createStreamFromResource');
        self::assertParameter($method, 0, 'resource', false, null, false, false);
        $returnType = $method->getReturnType();
        self::assertNotNull($returnType);
        self::assertSame(StreamInterface::class, $returnType->getName());
    }

    public function testCreateStreamFromResourceDocblock(): void
    {
        $doc = (new ReflectionMethod(StreamFactoryInterface::class, 'createStreamFromResource'))->getDocComment();
        self::assertIsString($doc);
        self::assertStringContainsString('MUST be readable', $doc);
    }

    public function testCreateStreamFromResourceReturnsDeclaredType(): void
    {
        $handle = fopen('php://temp', 'rb');
        self::assertIsResource($handle);
        $method = new ReflectionMethod(StreamFactoryInterface::class, 'createStreamFromResource');
        $factory = new StreamFactoryDouble();
        self::assertReturnTypeMatchesReflection(
            $method,
            $factory->createStreamFromResource($handle),
            StreamInterface::class
        );
        fclose($handle);
    }
}

<?php

declare(strict_types=1);

namespace HttpFactory\Tests;

use HttpFactory\Tests\Double\NullStream;
use HttpFactory\Tests\Double\UploadedFileFactoryDouble;
use HttpFactory\Tests\Support\ParameterSignatureAssertion;
use HttpFactory\Tests\Support\ReturnTypeAssertion;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;
use ReflectionMethod;

final class UploadedFileFactoryInterfaceTest extends TestCase
{
    use ParameterSignatureAssertion;
    use ReturnTypeAssertion;

    public function testCreateUploadedFileSignature(): void
    {
        $method = new ReflectionMethod(UploadedFileFactoryInterface::class, 'createUploadedFile');
        self::assertParameter($method, 0, 'stream', true, StreamInterface::class, false, false);
        self::assertParameter($method, 1, 'size', true, 'int', true, true, null);
        self::assertParameter(
            $method,
            2,
            'error',
            true,
            'int',
            false,
            true,
            UPLOAD_ERR_OK,
            true,
            'UPLOAD_ERR_OK'
        );
        self::assertParameter($method, 3, 'clientFilename', true, 'string', true, true, null);
        self::assertParameter($method, 4, 'clientMediaType', true, 'string', true, true, null);
        $returnType = $method->getReturnType();
        self::assertNotNull($returnType);
        self::assertSame(UploadedFileInterface::class, $returnType->getName());
    }

    public function testCreateUploadedFileDocblock(): void
    {
        $doc = (new ReflectionMethod(UploadedFileFactoryInterface::class, 'createUploadedFile'))->getDocComment();
        self::assertIsString($doc);
        self::assertStringContainsString('@throws \\InvalidArgumentException', $doc);
        self::assertStringContainsString('If the file resource is not readable', $doc);
    }

    public function testCreateUploadedFileReturnsDeclaredType(): void
    {
        $stream = new NullStream();
        $factory = new UploadedFileFactoryDouble();
        $method = new ReflectionMethod(UploadedFileFactoryInterface::class, 'createUploadedFile');
        self::assertReturnTypeMatchesReflection($method, $factory->createUploadedFile($stream), UploadedFileInterface::class);
        self::assertReturnTypeMatchesReflection(
            $method,
            $factory->createUploadedFile($stream, 3, UPLOAD_ERR_OK, 'a.txt', 'text/plain'),
            UploadedFileInterface::class
        );
        self::assertReturnTypeMatchesReflection(
            $method,
            $factory->createUploadedFile($stream, null, UPLOAD_ERR_NO_FILE, null, null),
            UploadedFileInterface::class
        );
    }
}

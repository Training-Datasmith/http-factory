<?php

declare(strict_types=1);

namespace HttpFactory\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use ReflectionClass;

final class InterfaceInventoryTest extends TestCase
{
    private const EXPECTED_FILES = [
        'RequestFactoryInterface.php',
        'ResponseFactoryInterface.php',
        'ServerRequestFactoryInterface.php',
        'StreamFactoryInterface.php',
        'UploadedFileFactoryInterface.php',
        'UriFactoryInterface.php',
    ];

    /**
     * @return array<string, class-string>
     */
    private static function interfaceMap(): array
    {
        return [
            'StreamFactoryInterface.php' => StreamFactoryInterface::class,
            'RequestFactoryInterface.php' => RequestFactoryInterface::class,
            'ResponseFactoryInterface.php' => ResponseFactoryInterface::class,
            'ServerRequestFactoryInterface.php' => ServerRequestFactoryInterface::class,
            'UploadedFileFactoryInterface.php' => UploadedFileFactoryInterface::class,
            'UriFactoryInterface.php' => UriFactoryInterface::class,
        ];
    }

    public function testSrcContainsOnlyTheSixFactoryInterfaces(): void
    {
        $files = array_values(array_filter(
            scandir(__DIR__ . '/../src'),
            static function (string $entry): bool {
                return substr($entry, -4) === '.php';
            }
        ));
        sort($files);

        self::assertSame(self::EXPECTED_FILES, $files);
    }

    public function testEachInterfaceIsLoadedFromItsSrcFile(): void
    {
        foreach (self::interfaceMap() as $filename => $class) {
            self::assertTrue(interface_exists($class));
            $reflection = new ReflectionClass($class);
            self::assertTrue($reflection->isInterface());
            self::assertSame('Psr\Http\Message', $reflection->getNamespaceName());
            self::assertSame([], $reflection->getInterfaceNames());

            $expected = realpath(__DIR__ . '/../src/' . $filename);
            self::assertIsString($expected);
            $actual = realpath($reflection->getFileName());
            self::assertIsString($actual);
            self::assertSame($expected, $actual);
        }
    }

    public function testFactoryInterfacesAreNotLoadedFromHttpMessage(): void
    {
        $streamInterfaceFile = realpath(
            __DIR__ . '/../vendor/psr/http-message/src/StreamInterface.php'
        );
        self::assertIsString($streamInterfaceFile);

        $factoryFile = realpath(__DIR__ . '/../src/StreamFactoryInterface.php');
        self::assertIsString($factoryFile);

        $streamReflection = new ReflectionClass(StreamInterface::class);
        $factoryReflection = new ReflectionClass(StreamFactoryInterface::class);

        self::assertSame($streamInterfaceFile, realpath($streamReflection->getFileName()));
        self::assertSame($factoryFile, realpath($factoryReflection->getFileName()));
    }

    public function testMethodSets(): void
    {
        self::assertSame(
            ['createStream', 'createStreamFromFile', 'createStreamFromResource'],
            array_map(
                static function (\ReflectionMethod $method): string {
                    return $method->getName();
                },
                (new ReflectionClass(StreamFactoryInterface::class))->getMethods()
            )
        );
        self::assertSame(
            ['createRequest'],
            array_map(
                static function (\ReflectionMethod $method): string {
                    return $method->getName();
                },
                (new ReflectionClass(RequestFactoryInterface::class))->getMethods()
            )
        );
        self::assertSame(
            ['createResponse'],
            array_map(
                static function (\ReflectionMethod $method): string {
                    return $method->getName();
                },
                (new ReflectionClass(ResponseFactoryInterface::class))->getMethods()
            )
        );
        self::assertSame(
            ['createServerRequest'],
            array_map(
                static function (\ReflectionMethod $method): string {
                    return $method->getName();
                },
                (new ReflectionClass(ServerRequestFactoryInterface::class))->getMethods()
            )
        );
        self::assertSame(
            ['createUploadedFile'],
            array_map(
                static function (\ReflectionMethod $method): string {
                    return $method->getName();
                },
                (new ReflectionClass(UploadedFileFactoryInterface::class))->getMethods()
            )
        );
        self::assertSame(
            ['createUri'],
            array_map(
                static function (\ReflectionMethod $method): string {
                    return $method->getName();
                },
                (new ReflectionClass(UriFactoryInterface::class))->getMethods()
            )
        );
    }
}

<?php

declare(strict_types=1);

namespace HttpFactory\Tests\Double;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

final class StreamFactoryDouble implements StreamFactoryInterface
{
    public function createStream(string $content = ''): StreamInterface
    {
        return new NullStream();
    }

    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return new NullStream();
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        return new NullStream();
    }
}

<?php

declare(strict_types=1);

namespace HttpFactory\Tests\Double;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

final class UriFactoryDouble implements UriFactoryInterface
{
    public function createUri(string $uri = ''): UriInterface
    {
        return new NullUri();
    }
}

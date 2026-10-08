<?php

declare(strict_types=1);

namespace HttpFactory\Tests\Double;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

final class NullRequest implements RequestInterface
{
    use MessageMethods;

    public function getRequestTarget()
    {
        return '/';
    }

    public function withRequestTarget($requestTarget)
    {
        return $this;
    }

    public function getMethod()
    {
        return 'GET';
    }

    public function withMethod($method)
    {
        return $this;
    }

    public function getUri()
    {
        return new NullUri();
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        return $this;
    }
}

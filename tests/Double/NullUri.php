<?php

declare(strict_types=1);

namespace HttpFactory\Tests\Double;

use Psr\Http\Message\UriInterface;

final class NullUri implements UriInterface
{
    public function getScheme()
    {
        return '';
    }

    public function getAuthority()
    {
        return '';
    }

    public function getUserInfo()
    {
        return '';
    }

    public function getHost()
    {
        return '';
    }

    public function getPort()
    {
        return null;
    }

    public function getPath()
    {
        return '';
    }

    public function getQuery()
    {
        return '';
    }

    public function getFragment()
    {
        return '';
    }

    public function withScheme($scheme)
    {
        return $this;
    }

    public function withUserInfo($user, $password = null)
    {
        return $this;
    }

    public function withHost($host)
    {
        return $this;
    }

    public function withPort($port)
    {
        return $this;
    }

    public function withPath($path)
    {
        return $this;
    }

    public function withQuery($query)
    {
        return $this;
    }

    public function withFragment($fragment)
    {
        return $this;
    }

    public function __toString()
    {
        return '';
    }
}

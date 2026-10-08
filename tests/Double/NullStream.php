<?php

declare(strict_types=1);

namespace HttpFactory\Tests\Double;

use Psr\Http\Message\StreamInterface;

final class NullStream implements StreamInterface
{
    public function __toString()
    {
        return '';
    }

    public function close()
    {
    }

    public function detach()
    {
        return null;
    }

    public function getSize()
    {
        return null;
    }

    public function tell()
    {
        return 0;
    }

    public function eof()
    {
        return true;
    }

    public function isSeekable()
    {
        return false;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
    }

    public function rewind()
    {
    }

    public function isWritable()
    {
        return false;
    }

    public function write($string)
    {
        return 0;
    }

    public function isReadable()
    {
        return false;
    }

    public function read($length)
    {
        return '';
    }

    public function getContents()
    {
        return '';
    }

    public function getMetadata($key = null)
    {
        return null;
    }
}

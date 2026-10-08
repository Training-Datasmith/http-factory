<?php

declare(strict_types=1);

namespace HttpFactory\Tests\Double;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

final class NullUploadedFile implements UploadedFileInterface
{
    public function getStream()
    {
        return new NullStream();
    }

    public function moveTo($targetPath)
    {
    }

    public function getSize()
    {
        return null;
    }

    public function getError()
    {
        return UPLOAD_ERR_OK;
    }

    public function getClientFilename()
    {
        return null;
    }

    public function getClientMediaType()
    {
        return null;
    }
}

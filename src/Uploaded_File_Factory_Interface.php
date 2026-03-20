<?php

declare (strict_types=1);
namespace Psr\Http\Message;

interface Uploaded_File_Factory_Interface
{
    /**
     * Create a new uploaded file.
     *
     * If a size is not provided it will be determined by checking the size of
     * the file.
     *
     * @see http://php.net/manual/features.file-upload.post-method.php
     * @see http://php.net/manual/features.file-upload.errors.php
     *
     * @param StreamInterface $stream Underlying stream representing the
     *     uploaded file content.
     * @param int|null $size in bytes
     * @param int $error PHP file upload error
     * @param string|null $clientFilename Filename as provided by the client, if any.
     * @param string|null $clientMediaType Media type as provided by the client, if any.
     *
     *
     * @throws \InvalidArgumentException If the file resource is not readable.
     */
    public function create_uploaded_file(Stream_Interface $stream, ?int $size = null, int $error = \UPLOAD_ERR_OK, ?string $client_filename = null, ?string $client_media_type = null): Uploaded_File_Interface;
}
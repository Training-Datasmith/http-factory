<?php

declare (strict_types=1);
namespace Psr\Http\Message;

/**
 * Creates PSR-7 UploadedFile objects from stream data and upload metadata.
 *
 * @since 1.0
 * @see https://www.php-fig.org/psr/psr-17/
 */
interface Uploaded_File_Factory_Interface
{
    /**
     * Create a new uploaded file value object.
     *
     * If $size is not provided it will be determined by inspecting the stream
     * (typically via Stream_Interface::get_size()). For large uploads this may
     * require reading the full stream, so providing $size explicitly is preferred
     * when the value is already known (e.g., from $_FILES['size']).
     *
     * The $client_filename and $client_media_type values come directly from the
     * HTTP client and MUST NOT be trusted. Always validate and sanitise them
     * before using them in filesystem operations or Content-Type headers.
     *
     * @see https://www.php.net/manual/features.file-upload.post-method.php
     * @see https://www.php.net/manual/features.file-upload.errors.php
     *
     * @param Stream_Interface $stream A readable stream representing the uploaded
     *   file's content. This is typically a php://temp or filesystem-backed stream.
     * @param int|null $size The known file size in bytes, or null to infer it from
     *   the stream. Providing this explicitly avoids a stream-read for sizing.
     * @param int $error One of PHP's UPLOAD_ERR_* constants indicating upload
     *   success (UPLOAD_ERR_OK) or a specific failure reason. Defaults to
     *   UPLOAD_ERR_OK.
     * @param string|null $client_filename The original filename reported by the
     *   browser, or null if not provided. Do NOT use this as a filesystem path
     *   without sanitisation.
     * @param string|null $client_media_type The MIME type reported by the browser,
     *   or null if not provided. Do NOT trust this value; detect the real type
     *   using finfo or mime_content_type() instead.
     *
     * @throws \InvalidArgumentException If the stream is not readable, or if
     *   $error is not a valid UPLOAD_ERR_* constant value.
     *
     * @return Uploaded_File_Interface An immutable value object representing the
     *   uploaded file with the given stream, size, error code, and client metadata.
     *
     * @since 1.0
     */
    public function create_uploaded_file(
        Stream_Interface $stream,
        ?int $size = null,
        int $error = \UPLOAD_ERR_OK,
        ?string $client_filename = null,
        ?string $client_media_type = null,
    ): Uploaded_File_Interface;
}
<?php

declare (strict_types=1);
namespace Psr\Http\Message;

/**
 * Creates PSR-7 Stream objects from various sources.
 *
 * @since 1.0
 * @see https://www.php-fig.org/psr/psr-17/
 */
interface Stream_Factory_Interface
{
    /**
     * Create a new in-memory stream populated with the given string content.
     *
     * The stream SHOULD be backed by a php://temp or php://memory resource
     * so it does not touch the filesystem. The resulting stream is readable
     * and seekable; writability is implementation-defined.
     *
     * @param string $content The initial content to write into the stream.
     *   Pass an empty string to create an empty stream. For large content,
     *   prefer create_stream_from_file() to avoid loading everything into RAM.
     *
     * @return Stream_Interface A new readable, seekable stream containing $content.
     *
     * @since 1.0
     */
    public function create_stream(string $content = ''): Stream_Interface;

    /**
     * Create a stream backed by a file on the filesystem.
     *
     * The file MUST be opened using the given $mode, which may be any mode
     * supported by PHP's fopen() function. The $filename MAY be any URI
     * supported by fopen(), including stream wrappers such as s3:// or php://.
     *
     * @param string $filename Filesystem path or stream URI to open. The file
     *   must be accessible to the PHP process with the given $mode.
     * @param string $mode The fopen() mode string (e.g., 'r', 'w', 'a', 'r+').
     *   Defaults to 'r' (read-only). See php.net/fopen for valid modes.
     *
     * @throws \RuntimeException If the file cannot be opened (e.g., not found,
     *   permission denied, or the path is a directory).
     * @throws \InvalidArgumentException If $mode is not a recognised fopen mode.
     *
     * @return Stream_Interface A stream wrapping the opened file handle.
     *
     * @since 1.0
     */
    public function create_stream_from_file(string $filename, string $mode = 'r'): Stream_Interface;

    /**
     * Create a PSR-7 stream wrapping an existing PHP stream resource.
     *
     * The stream MUST be readable. Whether it is also seekable or writable
     * depends on the underlying resource and what mode it was opened with.
     * Ownership of the resource is transferred to the returned stream object,
     * which will close the resource when detach() or close() is called.
     *
     * @param resource $resource An open, readable PHP stream resource (e.g.,
     *   the result of fopen(), tmpfile(), or STDIN).
     *
     * @throws \InvalidArgumentException If $resource is not a stream resource.
     *
     * @return Stream_Interface A stream wrapping the provided resource.
     *
     * @since 1.0
     */
    public function create_stream_from_resource($resource): Stream_Interface;
}
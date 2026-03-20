<?php

declare(strict_types=1);

/**
 * Example: Using PSR-17 factories to create PSR-7 HTTP messages.
 *
 * Libraries that need to create HTTP messages should accept factory interfaces,
 * not concrete PSR-7 classes, so they remain independent of any specific
 * implementation (Guzzle Psr7, Nyholm Psr7, Laminas Diactoros, etc.).
 */

use Psr\Http\Message\Request_Factory_Interface;
use Psr\Http\Message\Response_Factory_Interface;
use Psr\Http\Message\Stream_Factory_Interface;
use Psr\Http\Message\Uri_Factory_Interface;

// --- A library component that creates HTTP messages via factories ---

final class Json_Response_Builder
{
    public function __construct(
        private readonly Response_Factory_Interface $response_factory,
        private readonly Stream_Factory_Interface   $stream_factory,
    ) {}

    /**
     * Build a JSON HTTP response.
     *
     * @param array<string, mixed> $data The data to encode as JSON.
     * @param int $status HTTP status code (default 200).
     */
    public function build(array $data, int $status = 200): \Psr\Http\Message\Response_Interface
    {
        $json   = json_encode($data, JSON_THROW_ON_ERROR);
        $stream = $this->stream_factory->create_stream($json);

        return $this->response_factory
            ->create_response($status)
            ->with_header('Content-Type', 'application/json')
            ->with_header('Content-Length', (string) strlen($json))
            ->with_body($stream);
    }
}

// --- Building an outgoing API request ---

final class Api_Request_Builder
{
    public function __construct(
        private readonly Request_Factory_Interface $request_factory,
        private readonly Stream_Factory_Interface  $stream_factory,
        private readonly Uri_Factory_Interface     $uri_factory,
    ) {}

    /**
     * Create a POST request with a JSON body.
     *
     * @param string $url The target URL.
     * @param array<string, mixed> $payload The request body data.
     */
    public function post(string $url, array $payload): \Psr\Http\Message\Request_Interface
    {
        $json   = json_encode($payload, JSON_THROW_ON_ERROR);
        $uri    = $this->uri_factory->create_uri($url);
        $stream = $this->stream_factory->create_stream($json);

        return $this->request_factory
            ->create_request('POST', $uri)
            ->with_header('Content-Type', 'application/json')
            ->with_header('Content-Length', (string) strlen($json))
            ->with_body($stream);
    }
}

// --- Stream factory usage: wrapping an existing file ---
// $stream_factory->create_stream_from_file('/path/to/large-upload.bin', 'r');
// $stream_factory->create_stream_from_resource(fopen('php://input', 'r'));

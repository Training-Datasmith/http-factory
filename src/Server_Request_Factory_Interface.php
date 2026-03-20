<?php

declare (strict_types=1);
namespace Psr\Http\Message;

/**
 * Creates PSR-7 ServerRequest objects for incoming server-side HTTP requests.
 *
 * @since 1.0
 * @see https://www.php-fig.org/psr/psr-17/
 */
interface Server_Request_Factory_Interface
{
    /**
     * Create a new server-side HTTP request from explicit components.
     *
     * Server params are taken precisely as given — no parsing or normalisation
     * of the values is performed. In particular, no attempt is made to derive
     * the HTTP method or URI from $server_params; they MUST be provided explicitly.
     * This is intentional to avoid ambiguity between SAPI environments.
     *
     * @param string $method The HTTP method for the request (e.g., 'GET', 'POST').
     *   Must be provided explicitly; it MUST NOT be inferred from $server_params.
     * @param Uri_Interface|string $uri The full request URI. A string value MUST
     *   be parsed into a Uri_Interface instance by the factory. Must be provided
     *   explicitly; it MUST NOT be inferred from $server_params.
     * @param array<string, mixed> $server_params SAPI parameters to seed the
     *   request with, typically the contents of $_SERVER. The factory stores
     *   them as-is without interpretation.
     *
     * @throws \InvalidArgumentException If $method is empty or $uri is unparsable.
     *
     * @return Server_Request_Interface A new server request populated with the
     *   given method, URI, and server params. Cookies, query params, uploaded
     *   files, and parsed body are initially empty.
     *
     * @since 1.0
     */
    public function create_server_request(string $method, Uri_Interface|string $uri, array $server_params = []): Server_Request_Interface;
}
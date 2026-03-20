<?php

declare (strict_types=1);
namespace Psr\Http\Message;

/**
 * Creates PSR-7 Request objects.
 *
 * @since 1.0
 * @see https://www.php-fig.org/psr/psr-17/
 */
interface Request_Factory_Interface
{
    /**
     * Create a new outgoing client-side HTTP request.
     *
     * @param string $method The HTTP method for the request (e.g., 'GET',
     *   'POST', 'PUT', 'DELETE'). The method is case-sensitive per the HTTP
     *   specification; pass it exactly as it should appear on the wire.
     * @param Uri_Interface|string $uri The target URI for the request. A string
     *   value MUST be parsed into a Uri_Interface instance by the factory.
     *   Relative URIs are accepted; resolution against a base is the caller's
     *   responsibility.
     *
     * @throws \InvalidArgumentException If the $method is empty or the $uri
     *   string cannot be parsed into a valid URI.
     *
     * @return Request_Interface A new, fully-formed request object with the
     *   given method and URI. Headers and body are empty by default.
     *
     * @since 1.0
     */
    public function create_request(string $method, Uri_Interface|string $uri): Request_Interface;
}
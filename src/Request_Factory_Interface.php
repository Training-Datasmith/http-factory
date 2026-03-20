<?php

declare (strict_types=1);
namespace Psr\Http\Message;

interface Request_Factory_Interface
{
    /**
     * Create a new request.
     *
     * @param string $method The HTTP method associated with the request.
     * @param UriInterface|string $uri The URI associated with the request. If
     *     the value is a string, the factory MUST create a UriInterface
     *     instance based on it.
     */
    public function create_request(string $method, $uri): Request_Interface;
}
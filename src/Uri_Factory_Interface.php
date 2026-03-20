<?php

declare (strict_types=1);
namespace Psr\Http\Message;

/**
 * Creates PSR-7 URI value objects from string representations.
 *
 * @since 1.0
 * @see https://www.php-fig.org/psr/psr-17/
 */
interface Uri_Factory_Interface
{
    /**
     * Create a new URI value object from a URI string.
     *
     * The factory MUST parse the URI string into its components (scheme,
     * authority, path, query, fragment) according to RFC 3986. An empty string
     * is a valid relative URI reference and MUST NOT throw.
     *
     * @param string $uri The URI string to parse. May be an absolute URI
     *   (e.g., 'https://example.com/path?q=1#frag'), a relative reference
     *   (e.g., '/path'), or an empty string for an empty URI.
     *
     * @throws \InvalidArgumentException If $uri is not empty and cannot be
     *   parsed as a valid URI reference per RFC 3986.
     *
     * @return Uri_Interface An immutable URI value object with components
     *   populated from the parsed string. Modifying any component requires
     *   calling the appropriate with_*() method, which returns a new instance.
     *
     * @since 1.0
     */
    public function create_uri(string $uri = ''): Uri_Interface;
}
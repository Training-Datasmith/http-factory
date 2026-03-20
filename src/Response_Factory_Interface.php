<?php

declare (strict_types=1);
namespace Psr\Http\Message;

/**
 * Creates PSR-7 Response objects.
 *
 * @since 1.0
 * @see https://www.php-fig.org/psr/psr-17/
 */
interface Response_Factory_Interface
{
    /**
     * Create a new server-side HTTP response.
     *
     * @param int $code The HTTP status code for the response. Must be a valid
     *   3-digit integer in the range 100–599. Defaults to 200 (OK).
     * @param string $reason_phrase An optional human-readable phrase describing
     *   the status code. If empty, the factory MAY use the standard IANA reason
     *   phrase for the given status code (e.g., "OK" for 200, "Not Found" for 404).
     *
     * @throws \InvalidArgumentException If $code is outside the valid 100–599
     *   range or otherwise not a legal HTTP status code.
     *
     * @return Response_Interface A new response with an empty body and the
     *   specified status code and reason phrase.
     *
     * @since 1.0
     */
    public function create_response(int $code = 200, string $reason_phrase = ''): Response_Interface;
}
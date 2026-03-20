<?php

declare (strict_types=1);
namespace Psr\Http\Message;

interface Response_Factory_Interface
{
    /**
     * Create a new response.
     *
     * @param int $code HTTP status code; defaults to 200
     * @param string $reasonPhrase Reason phrase to associate with status code
     *     in generated response; if none is provided implementations MAY use
     *     the defaults as suggested in the HTTP specification.
     */
    public function create_response(int $code = 200, string $reason_phrase = ''): Response_Interface;
}
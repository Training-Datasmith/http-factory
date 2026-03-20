<?php

declare (strict_types=1);
namespace Psr\Http\Message;

interface Uri_Factory_Interface
{
    /**
     * Create a new URI.
     *
     *
     *
     * @throws \InvalidArgumentException If the given URI cannot be parsed.
     */
    public function create_uri(string $uri = ''): Uri_Interface;
}
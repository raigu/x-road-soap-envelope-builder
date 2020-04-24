<?php

namespace Raigu\XRoad;

use Psr\Http\Message\StreamInterface;

final class SoapEnvelopeBuilder
{
    public function build(): StreamInterface
    {
        return Stream::empty();
    }

    public static function create(): self
    {
        return new self();
    }

    private function __construct()
    {
    }
}

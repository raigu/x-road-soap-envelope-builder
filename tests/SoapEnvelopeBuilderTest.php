<?php

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelopeBuilder;

final class SoapEnvelopeBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function builds_PSR7_StreamInterface_compatible_instance()
    {
        $this->assertInstanceOf(
            \Psr\Http\Message\StreamInterface::class,
            SoapEnvelopeBuilder::create()->build()
        );
    }
}

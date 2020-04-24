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

    /**
     * @test
     */
    public function builds_instance_containing_valid_SOAP_envelope_xml()
    {
        $envelope = SoapEnvelopeBuilder::create()->build();

        $dom = new \DOMDocument;
        $dom->loadXML(strval($envelope));
        $this->assertTrue(
            $dom->schemaValidate(__DIR__ . '/soap-v1.1.xsd')
        );
    }
}

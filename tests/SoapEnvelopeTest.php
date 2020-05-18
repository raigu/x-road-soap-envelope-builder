<?php

namespace Raigu\XRoad\SoapEnvelope;

use PHPUnit\Framework\TestCase;

class SoapEnvelopeTest extends TestCase
{
    /**
     * @test
     */
    public function returns_SOAP_Envelope_xml_compatible_with_schema()
    {
        $envelope = SoapEnvelope::create(
            new NoneElement
        );

        $actual = $envelope->asStr();

        $dom = new \DOMDocument;
        $dom->loadXML($actual);
        $this->assertTrue(
            $dom->schemaValidate(__DIR__ . '/soap-v1.1.xsd')
        );
    }
}

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

    /**
     * @test
     */
    public function adds_service_into_SOAP_envelope()
    {
        $envelope = SoapEnvelopeBuilder::create()
            ->withService('EE/COM/00000000/SYS/method/v0')
            ->build();

        $dom = new DOMDocument;
        $dom->loadXML($envelope);
        $xpath = new DOMXPath($dom);

        $xpath->registerNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('xrd', 'http://x-road.eu/xsd/xroad.xsd');
        $xpath->registerNamespace('id', 'http://x-road.eu/xsd/identifiers');

        $elements = $xpath->query('/soap:Envelope/soap:Header/xrd:service');
        $this->assertEquals(1, $elements->length, 'Must contain element "service"');
        $service = $elements->item(0);

        $elements = $xpath->query('id:xRoadInstance', $service);
        $this->assertEquals('EE', $elements->item(0)->nodeValue);

        $elements = $xpath->query('id:memberClass', $service);
        $this->assertEquals('COM', $elements->item(0)->nodeValue);

        $elements = $xpath->query('id:memberCode', $service);
        $this->assertEquals('00000000', $elements->item(0)->nodeValue);

        $elements = $xpath->query('id:subsystemCode', $service);
        $this->assertEquals('SYS', $elements->item(0)->nodeValue);

        $elements = $xpath->query('id:serviceCode', $service);
        $this->assertEquals('method', $elements->item(0)->nodeValue);

        $elements = $xpath->query('id:serviceVersion', $service);
        $this->assertEquals('v0', $elements->item(0)->nodeValue);
    }
}

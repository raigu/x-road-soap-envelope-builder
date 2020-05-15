<?php

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelope\SoapEnvelopeBuilder;

final class SoapEnvelopeBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function builds_instance_containing_valid_SOAP_envelope_xml()
    {
        $envelope = SoapEnvelopeBuilder::stub()->build();

        $dom = new \DOMDocument;
        $dom->loadXML($envelope);
        $this->assertTrue(
            $dom->schemaValidate(__DIR__ . '/soap-v1.1.xsd')
        );
    }

    /**
     * @test
     */
    public function adds_service_into_SOAP_envelope()
    {
        $envelope = SoapEnvelopeBuilder::stub()
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

    /**
     * @test
     */
    public function adds_client_into_SOAP_envelope()
    {
        $envelope = SoapEnvelopeBuilder::stub()
            ->withClient('EE/COM/00000000/SYS')
            ->build();

        $dom = new DOMDocument;
        $dom->loadXML($envelope);
        $xpath = new DOMXPath($dom);

        $xpath->registerNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('xrd', 'http://x-road.eu/xsd/xroad.xsd');
        $xpath->registerNamespace('id', 'http://x-road.eu/xsd/identifiers');

        $elements = $xpath->query('/soap:Envelope/soap:Header/xrd:client');
        $this->assertEquals(1, $elements->length, 'Must contain element "client"');
        $service = $elements->item(0);

        $elements = $xpath->query('id:xRoadInstance', $service);
        $this->assertEquals('EE', $elements->item(0)->nodeValue);

        $elements = $xpath->query('id:memberClass', $service);
        $this->assertEquals('COM', $elements->item(0)->nodeValue);

        $elements = $xpath->query('id:memberCode', $service);
        $this->assertEquals('00000000', $elements->item(0)->nodeValue);

        $elements = $xpath->query('id:subsystemCode', $service);
        $this->assertEquals('SYS', $elements->item(0)->nodeValue);
    }

    /**
     * @test
     */
    public function adds_userId_into_SOAP_envelope()
    {
        $envelope = SoapEnvelopeBuilder::stub()
            ->withUserId(
                $expected = 'EE00000000000'
            )
            ->build();

        $dom = new \DOMDocument;
        $dom->loadXML($envelope);
        $xpath = new DOMXPath($dom);

        $xpath->registerNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('xrd', 'http://x-road.eu/xsd/xroad.xsd');

        $elements = $xpath->query('/soap:Envelope/soap:Header/xrd:userId');
        $this->assertEquals(1, $elements->length, 'Must contain element "userId"');
        $this->assertEquals($expected, $elements->item(0)->nodeValue);
    }

    /**
     * @test
     */
    public function adds_body_into_SOAP_envelope()
    {
        $envelope = SoapEnvelopeBuilder::stub()
            ->withBody(
                $expected = '<stub xmlns="http://stub.ee"></stub>'
            )
            ->build();

        $dom = new \DOMDocument;
        $dom->loadXML($envelope);
        $xpath = new DOMXPath($dom);

        $xpath->registerNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('ns', 'http://stub.ee');
        $elements = $xpath->query('/soap:Envelope/soap:Body/ns:stub');
        $content = $dom->saveXML(
            $elements->item(0)
        );

        $this->assertXmlStringEqualsXmlString(
            $expected,
            $content
        );
    }


    /**
     * @test
     */
    public function generates_unique_id_for_every_built_envelope()
    {
        $builder = SoapEnvelopeBuilder::stub();

        $envelope1 = $builder->build();
        $envelope2 = $builder->build();

        $id = function (string $envelope): string {
            $dom = new \DOMDocument;
            $dom->loadXML($envelope);

            $elements = $dom->getElementsByTagNameNS('http://x-road.eu/xsd/xroad.xsd', 'id');

            return $elements->item(0)->nodeValue;
        };

        $this->assertNotEquals(
            $id($envelope1),
            $id($envelope2)
        );
    }

    /**
     * @test
     */
    public function adds_representedParty_into_SOAP_envelope()
    {
        $envelope = SoapEnvelopeBuilder::stub()
            ->withRepresentedParty(
                'COM/12345678'
            )
            ->build();

        $dom = new \DOMDocument;
        $dom->loadXML($envelope);
        $xpath = new DOMXPath($dom);

        $xpath->registerNamespace('e', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('r', 'http://x-road.eu/xsd/representation.xsd');

        $elements = $xpath->query('/e:Envelope/e:Header/r:representedParty');
        $this->assertEquals(1, $elements->length, 'Must contain element "representedParty"');
    }


    /**
     * @test
     */
    public function throw_exception_if_mandatory_data_is_not_given()
    {
        $this->expectExceptionMessage('not initialized');
        SoapEnvelopeBuilder::create()->build();
    }
}

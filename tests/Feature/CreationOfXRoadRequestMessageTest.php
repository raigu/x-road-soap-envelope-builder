<?php

namespace Feature;

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelope\SoapEnvelope;
use Raigu\XRoad\SoapEnvelope\XRoadSoapMessageElementsFactory;

final class CreationOfXRoadRequestMessageTest extends TestCase
{
    /**
     * @test
     */
    public function creation_of_SOAP_envelope_with_mandatory_fields()
    {
        $factory = new XRoadSoapMessageElementsFactory();

        $sut = SoapEnvelope::create(
            $factory->service('EE/COM/11111111/PROVIDER_SYS/provider_method/v99'),
            $factory->client('EE/COM/22222222/CLIENT_SYS'),
            $factory->body('<serviceRequestStub/>'),
            $factory->userId('EE12343554'),
            $factory->representedParty('COM/00000000')
        );

        $actual = $sut->asStr();

        $dom = new \DOMDocument;
        $dom->loadXML($actual);
        $this->assertTrue(
            $dom->schemaValidate(__DIR__ . '/../Unit/soap-v1.1.xsd')
        );
    }
}

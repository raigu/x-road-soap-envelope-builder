<?php

namespace Feature;

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelope\SoapEnvelope;
use Raigu\XRoad\SoapEnvelope\ServiceRequest;
use Raigu\XRoad\SoapEnvelope\Client;
use Raigu\XRoad\SoapEnvelope\Id;
use Raigu\XRoad\SoapEnvelope\Issue;
use Raigu\XRoad\SoapEnvelope\RepresentedParty;
use Raigu\XRoad\SoapEnvelope\Service;
use Raigu\XRoad\SoapEnvelope\ClientReference;
use Raigu\XRoad\SoapEnvelope\RepresentedPartyReference;
use Raigu\XRoad\SoapEnvelope\ServiceReference;
use Raigu\XRoad\SoapEnvelope\UserId;

final class CreationOfXRoadRequestMessageTest extends TestCase
{
    /**
     * @test
     */
    public function creates_SOAP_Envelope()
    {
        $sut = new SoapEnvelope(
            new Client(
                new ClientReference('EE/GOV/MEMBER1/SUBSYSTEM1')
            ),
            new Service(
                new ServiceReference('EE/GOV/MEMBER2/SUBSYSTEM2/exampleService/v1')
            ),
            new ServiceRequest(
                '<ns1:exampleService xmlns:ns1="http://producer.x-road.eu">' .
                '<exampleInput>foo</exampleInput>' .
                '</ns1:exampleService>'
            ),
            new RepresentedParty(
                new RepresentedPartyReference('COM/MEMBER3')
            ),
            new Id('4894e35d-bf0f-44a6-867a-8e51f1daa7e0'),
            new UserId('EE12345678901'),
            new Issue('12345')
        );

        $actual = $sut->asStr();

        // Base of expected sample is taken from official specification:
        // https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#e1-request
        // The representedParty tag is added according to:
        // https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html#c1-example-request
        $expected = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<env:Envelope
        xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:xrd="http://x-road.eu/xsd/xroad.xsd"
        xmlns:id="http://x-road.eu/xsd/identifiers">
    <env:Header>
        <xrd:client id:objectType="SUBSYSTEM">
            <id:xRoadInstance>EE</id:xRoadInstance>
            <id:memberClass>GOV</id:memberClass>
            <id:memberCode>MEMBER1</id:memberCode>
            <id:subsystemCode>SUBSYSTEM1</id:subsystemCode>
        </xrd:client>
        <xrd:service id:objectType="SERVICE">
            <id:xRoadInstance>EE</id:xRoadInstance>
            <id:memberClass>GOV</id:memberClass>
            <id:memberCode>MEMBER2</id:memberCode>
            <id:subsystemCode>SUBSYSTEM2</id:subsystemCode>
            <id:serviceCode>exampleService</id:serviceCode>
            <id:serviceVersion>v1</id:serviceVersion>
        </xrd:service>
        <repr:representedParty xmlns:repr="http://x-road.eu/xsd/representation.xsd">
            <repr:partyClass>COM</repr:partyClass>
            <repr:partyCode>MEMBER3</repr:partyCode>
        </repr:representedParty>
        <xrd:id>4894e35d-bf0f-44a6-867a-8e51f1daa7e0</xrd:id>
        <xrd:userId>EE12345678901</xrd:userId>
        <xrd:issue>12345</xrd:issue>
        <xrd:protocolVersion>4.0</xrd:protocolVersion>
    </env:Header>
    <env:Body>
        <ns1:exampleService xmlns:ns1="http://producer.x-road.eu">
            <exampleInput>foo</exampleInput>
        </ns1:exampleService>
    </env:Body>
</env:Envelope>
EOD;

        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }
}

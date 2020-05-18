<?php

namespace Feature;

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelope\SoapEnvelope;
use Raigu\XRoad\SoapEnvelope\StrAsBody;
use Raigu\XRoad\SoapEnvelope\StrAsClient;
use Raigu\XRoad\SoapEnvelope\StrAsId;
use Raigu\XRoad\SoapEnvelope\StrAsIssue;
use Raigu\XRoad\SoapEnvelope\StrAsRepresentedParty;
use Raigu\XRoad\SoapEnvelope\StrAsService;
use Raigu\XRoad\SoapEnvelope\StrAsUserId;

final class CreationOfXRoadRequestMessageTest extends TestCase
{
    /**
     * @test
     */
    public function creates_SOAP_Envelope()
    {
        $sut = new SoapEnvelope(
            new StrAsClient('EE/GOV/MEMBER1/SUBSYSTEM1'),
            new StrAsService('EE/GOV/MEMBER2/SUBSYSTEM2/exampleService/v1'),
            new StrAsBody(
                '<ns1:exampleService xmlns:ns1="http://producer.x-road.eu">' .
                '<exampleInput>foo</exampleInput>' .
                '</ns1:exampleService>'
            ),
            new StrAsRepresentedParty('COM/MEMBER3'),
            new StrAsId('4894e35d-bf0f-44a6-867a-8e51f1daa7e0'),
            new StrAsUserId('EE12345678901'),
            new StrAsIssue('12345')
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

<?php

namespace Raigu\XRoad;

use Psr\Http\Message\StreamInterface;

final class SoapEnvelopeBuilder
{
    public function build(): StreamInterface
    {
        //$service = explode('/', $this->service);
        $service = ['EE', 'COM', '00000000', 'SYS', 'method', 'v0'];

        // source of response sample: https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#e1-request
        $body = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
        xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:ns1="http://producer.x-road.eu"
        xmlns:xrd="http://x-road.eu/xsd/xroad.xsd"
        xmlns:id="http://x-road.eu/xsd/identifiers">
    <SOAP-ENV:Header>
        <xrd:client id:objectType="SUBSYSTEM">
            <id:xRoadInstance>EE</id:xRoadInstance>
            <id:memberClass>GOV</id:memberClass>
            <id:memberCode>MEMBER1</id:memberCode>
            <id:subsystemCode>SUBSYSTEM1</id:subsystemCode>
        </xrd:client>
        <xrd:service id:objectType="SERVICE">
            <id:xRoadInstance>{$service[0]}</id:xRoadInstance>
            <id:memberClass>{$service[1]}</id:memberClass>
            <id:memberCode>{$service[2]}</id:memberCode>
            <id:subsystemCode>{$service[3]}</id:subsystemCode>
            <id:serviceCode>{$service[4]}</id:serviceCode>
            <id:serviceVersion>{$service[5]}</id:serviceVersion>
        </xrd:service>
        <xrd:id>4894e35d-bf0f-44a6-867a-8e51f1daa7e0</xrd:id>
        <xrd:userId>EE12345678901</xrd:userId>
        <xrd:issue>12345</xrd:issue>
        <xrd:protocolVersion>4.0</xrd:protocolVersion>
    </SOAP-ENV:Header>
    <SOAP-ENV:Body>
        <ns1:exampleService>
            <exampleInput>foo</exampleInput>
        </ns1:exampleService>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
EOD;

        return Stream::fromStr(
            $body
        );
    }

    public static function create(): self
    {
        return new self();
    }

    private function __construct()
    {
    }
}

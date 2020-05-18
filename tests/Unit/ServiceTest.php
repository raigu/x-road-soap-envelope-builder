<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use DOMXPath;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    /**
     * @test
     */
    public function injects_given_data_into_SOAP_header_under_service()
    {
        $dom = new DOMDocument;
        $dom->loadXML(<<<EOD
<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"> 
    <env:Header/>
</env:Envelope>
EOD
        );

        $sut = new Service([
            'TestKey' => 'TestValue',
        ]);
        $sut->inject($dom);

        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('env', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('xrd', 'http://x-road.eu/xsd/xroad.xsd');
        $xpath->registerNamespace('id', 'http://x-road.eu/xsd/identifiers');

        $elements = $xpath->query('/env:Envelope/env:Header/xrd:service[@id:objectType="SERVICE"]/id:TestKey');

        $this->assertEquals(
            'TestValue',
            $elements->item(0)->nodeValue
        );
    }
}

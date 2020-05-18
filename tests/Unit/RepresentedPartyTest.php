<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use DOMXPath;
use PHPUnit\Framework\TestCase;

class RepresentedPartyTest extends TestCase
{
    /**
     * @test
     */
    public function injects_given_data_into_SOAP_header_under_representedParty()
    {
        $dom = new DOMDocument;
        $dom->loadXML(<<<EOD
<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/">
    <env:Header/>
</env:Envelope>
EOD
        );

        $sut = new RepresentedParty([
            'TestKey' => 'TestValue',
        ]);
        $sut->inject($dom);

        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('env', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('repr', 'http://x-road.eu/xsd/representation.xsd');
        $elements = $xpath->query('/env:Envelope/env:Header/repr:representedParty/repr:TestKey');

        $this->assertEquals(
            'TestValue',
            $elements->item(0)->nodeValue
        );
    }
}

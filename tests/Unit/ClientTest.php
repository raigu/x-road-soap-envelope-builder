<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use DOMXPath;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function can_be_created_from_associative_array()
    {


        $dom = new DOMDocument;
        $dom->loadXML(<<<EOD
<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"> 
    <env:Header/>
</env:Envelope>
EOD
        );

        $sut = new Client([
            'TestKey' => 'TestValue',
        ]);
        $sut->inject($dom);

        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('env', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('xrd', 'http://x-road.eu/xsd/xroad.xsd');
        $xpath->registerNamespace('id', 'http://x-road.eu/xsd/identifiers');

        $elements = $xpath->query('/env:Envelope/env:Header/xrd:client[@id:objectType="SUBSYSTEM"]/id:TestKey');

        $this->assertEquals(
            'TestValue',
            $elements->item(0)->nodeValue
        );
    }

}

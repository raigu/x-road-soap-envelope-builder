<?php

namespace Raigu\XRoad\SoapEnvelope;

use PHPUnit\Framework\TestCase;

class UniqueIdTest extends TestCase
{
    /**
     * @test
     */
    public function injects_unique_id_into_SOAP_Header()
    {
        $envelope = '<?xml version="1.0" encoding="UTF-8"?>
<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" 
                   xmlns:id="http://x-road.eu/xsd/identifiers"
                   xmlns:xrd="http://x-road.eu/xsd/xroad.xsd">
    <env:Header/>
    <env:Body/>
</env:Envelope>';

        $dom1 = new \DOMDocument;
        $dom1->loadXML($envelope);

        $id1 = new UniqueId();
        $id1->inject($dom1);

        $dom2 = new \DOMDocument;
        $dom2->loadXML($envelope);

        $id2 = new UniqueId();
        $id2->inject($dom2);

        $this->assertNotEquals(
            $dom1->getElementsByTagNameNS(
                'http://x-road.eu/xsd/xroad.xsd',
                'id'
            )->item(0)->nodeValue,
            $dom2->getElementsByTagNameNS(
                'http://x-road.eu/xsd/xroad.xsd',
                'id'
            )->item(0)->nodeValue
        );
    }
}

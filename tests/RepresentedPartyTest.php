<?php

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelope\RepresentedParty;

final class RepresentedPartyTest extends TestCase
{
    /**
     * @var DOMDocument
     */
    private $dom;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dom = new \DOMDocument();
        $this->dom->loadXML(<<<EOD
                            <env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"> 
                                <env:Header/>
                            </env:Envelope>
EOD
        );
    }


    /**
     * @test
     */
    public function injects_representative_into_SOAP_Header()
    {
        $sut = RepresentedParty::fromStr('COM/12345678');

        $sut->inject($this->dom);

        $xpath = new DOMXPath($this->dom);
        $xpath->registerNamespace('e', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('r', 'http://x-road.eu/xsd/representation.xsd');


        $elements = $xpath->query('/e:Envelope/e:Header/r:representedParty/r:partyClass');
        $this->assertEquals(
            'COM',
            $elements->item(0)->nodeValue
        );

        $elements = $xpath->query('/e:Envelope/e:Header/r:representedParty/r:partyCode');
        $this->assertEquals(
            '12345678',
            $elements->item(0)->nodeValue
        );
    }
}

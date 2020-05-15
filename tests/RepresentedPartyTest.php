<?php

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelope\RepresentedParty;
use Raigu\XRoad\SoapEnvelope\XmlInjectable;

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
        $sut = RepresentedParty::create('COM', '12345678');

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


    /**
     * @test
     */
    public function representative_party_class_is_optional()
    {
        $sut = RepresentedParty::fromCode('12345678');

        $sut->inject($this->dom);

        $xpath = new DOMXPath($this->dom);
        $xpath->registerNamespace('e', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xpath->registerNamespace('r', 'http://x-road.eu/xsd/representation.xsd');


        $elements = $xpath->query('/e:Envelope/e:Header/r:representedParty/r:partyClass');
        $this->assertSame(
            0,
            $elements->count()
        );
    }

    /**
     * @test
     */
    public function can_be_created_from_string()
    {
        $this->assertInstanceOf(
            XmlInjectable::class,
            RepresentedParty::fromStr('')
        );
    }
}

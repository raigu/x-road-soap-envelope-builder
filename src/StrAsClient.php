<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I create a service element of X-Road SOAP envelope
 * which can inject itself into proper place in DOMDocument
 */
final class StrAsClient implements XmlInjectable
{
    /**
     * @var FragmentInjection
     */
    private $injection;

    public function inject(DOMDocument $dom): void
    {
        $this->injection->inject($dom);
    }

    public function __construct(string $reference)
    {
        $client = new StrAsClientReference($reference);

        $fragment = <<<EOD
<xrd:client id:objectType="SUBSYSTEM" 
    xmlns:xrd="http://x-road.eu/xsd/xroad.xsd"
    xmlns:id="http://x-road.eu/xsd/identifiers">
            <id:xRoadInstance>{$client->xRoadInstance()}</id:xRoadInstance>
            <id:memberClass>{$client->memberClass()}</id:memberClass>
            <id:memberCode>{$client->memberCode()}</id:memberCode>
            <id:subsystemCode>{$client->subSystemCode()}</id:subsystemCode>
</xrd:client>
EOD;

        $this->injection = new FragmentInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            $fragment
        );
    }
}

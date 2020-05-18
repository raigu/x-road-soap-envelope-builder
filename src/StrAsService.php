<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

final class StrAsService implements XmlInjectable
{
    /**
     * @var XmlInjectable
     */
    private $injector;

    public function inject(DOMDocument $dom): void
    {
        $this->injector->inject($dom);
    }

    public function __construct(string $reference)
    {
        $service = new StrAsServiceReference($reference);

        $fragment = <<<EOD
<xrd:service id:objectType="SERVICE" 
    xmlns:xrd="http://x-road.eu/xsd/xroad.xsd"
    xmlns:id="http://x-road.eu/xsd/identifiers">
            <id:xRoadInstance>{$service->xRoadInstance()}</id:xRoadInstance>
            <id:memberClass>{$service->memberClass()}</id:memberClass>
            <id:memberCode>{$service->memberCode()}</id:memberCode>
            <id:subsystemCode>{$service->subSystemCode()}</id:subsystemCode>
            <id:serviceCode>{$service->serviceCode()}</id:serviceCode>
            <id:serviceVersion>{$service->serviceVersion()}</id:serviceVersion>
</xrd:service>
EOD;

        $this->injector = new FragmentInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            $fragment
        );
    }

}

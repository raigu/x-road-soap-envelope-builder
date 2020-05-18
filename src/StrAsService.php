<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I am a service of X-Road
 *
 * I can inject myself into SOAP envelope header
 */
final class StrAsService implements XmlInjectable
{
    /**
     * @var XmlInjectable[]
     */
    private $injectors;

    public function inject(DOMDocument $dom): void
    {
        foreach ($this->injections as $injection) {
            $injection->inject($dom);
        }
    }

    public function __construct(string $reference)
    {
        $this->injections = [
            new FragmentInjection(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'Header',
                '<xrd:service xmlns:xrd="http://x-road.eu/xsd/xroad.xsd" ' .
                'xmlns:id="http://x-road.eu/xsd/identifiers" ' .
                'id:objectType="SERVICE"/>'
            ),
        ];

        $names = ['xRoadInstance', 'memberClass', 'memberCode', 'subsystemCode', 'serviceCode', 'serviceVersion'];
        $values = explode('/', $reference);

        foreach (array_combine($names, $values) as $name => $value) {
            $this->injections[] = new DOMElementInjection(
                'http://x-road.eu/xsd/xroad.xsd',
                'service',
                new \DOMElement($name, $value, 'http://x-road.eu/xsd/identifiers')
            );
        }
    }
}

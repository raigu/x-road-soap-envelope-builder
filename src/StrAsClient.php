<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I create a service element of X-Road SOAP envelope
 * which can inject itself into proper place in DOMDocument
 */
final class StrAsClient implements XmlInjectable
{
    /**
     * @var XmlInjectable[]
     */
    private $injections;

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
                '<xrd:client xmlns:xrd="http://x-road.eu/xsd/xroad.xsd" ' .
                'xmlns:id="http://x-road.eu/xsd/identifiers" ' .
                'id:objectType="SUBSYSTEM"/>'
            ),
        ];

        $names = ['xRoadInstance', 'memberClass', 'memberCode', 'subsystemCode'];
        $values = explode('/', $reference);

        foreach (array_combine($names, $values) as $name => $value) {
            $this->injections[] = new DOMElementInjection(
                'http://x-road.eu/xsd/xroad.xsd',
                'client',
                new \DOMElement($name, $value, 'http://x-road.eu/xsd/identifiers')
            );
        }
    }
}

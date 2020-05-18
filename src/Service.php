<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;
use Traversable;

/**
 * I am a service of X-Road
 *
 * I can inject myself into SOAP envelope header
 */
final class Service implements XmlInjectable
{
    /**
     * @var XmlInjectable[]
     */
    private $elements;

    public function inject(DOMDocument $dom): void
    {
        foreach ($this->elements as $injection) {
            $injection->inject($dom);
        }
    }

    public function __construct(Traversable $reference)
    {
        $this->elements = [
            new FragmentInjection(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'Header',
                '<xrd:service xmlns:xrd="http://x-road.eu/xsd/xroad.xsd" ' .
                'xmlns:id="http://x-road.eu/xsd/identifiers" ' .
                'id:objectType="SERVICE"/>'
            ),
        ];



        foreach ($reference as $name => $value) {
            $this->elements[] = new DOMElementInjection(
                'http://x-road.eu/xsd/xroad.xsd',
                'service',
                new \DOMElement($name, $value, 'http://x-road.eu/xsd/identifiers')
            );
        }
    }
}

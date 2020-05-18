<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;
use Traversable;

/**
 * I am the party who is represented by client.
 *
 * I know how to inject myself into SOAP envelope header.
 *
 * I fallow the specification "Third Party Representation Extension"
 * @see https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
 */
final class RepresentedParty implements XmlInjectable
{
    /**
     * @var XmlInjectable[]
     */
    private $elements;

    public function inject(DOMDocument $dom): void
    {
        foreach ($this->elements as $element) {
            $element->inject($dom);
        }
    }

    public function __construct(Traversable $reference)
    {
        $this->elements = [
            new FragmentInjection(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'Header',
                '<repr:representedParty xmlns:repr="http://x-road.eu/xsd/representation.xsd"/>'
            ),
        ];

        foreach ($reference as $name => $value) {
           $this->elements[] = new DOMElementInjection(
                'http://x-road.eu/xsd/representation.xsd',
                'representedParty',
                new \DOMElement($name, $value, 'http://x-road.eu/xsd/representation.xsd')
            );
        }
    }
}

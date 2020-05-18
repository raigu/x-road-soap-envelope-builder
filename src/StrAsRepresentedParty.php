<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I am represented party in X-Road SOAP Envelope.
 *
 * I know how to inject myself into SOAP Envelope.
 *
 * I fallow the specification "Third Party Representation Extension"
 * @see https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
 */
final class StrAsRepresentedParty implements XmlInjectable
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

    public function __construct(string $reference)
    {
        $this->elements = [
            new FragmentInjection(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'Header',
                '<repr:representedParty xmlns:repr="http://x-road.eu/xsd/representation.xsd"/>'
            ),
        ];

        $names = ['partyClass', 'partyCode'];
        $values = explode('/', $reference);

        foreach (array_combine($names, $values) as $name => $value) {
            $this->elements[] = new DOMElementInjection(
                'http://x-road.eu/xsd/representation.xsd',
                'representedParty',
                new \DOMElement($name, $value, 'http://x-road.eu/xsd/representation.xsd')
            );
        }
    }
}

<?php

namespace Raigu\XRoad\SoapEnvelope;

use Raigu\XRoad\SoapEnvelope\Element\ElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectionCollection;

/**
 * I create a represented party element
 * which can inject itself into X-Road SOAP Envelope.
 *
 * I create element according to the technical specification:
 * https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
 */
final class RepresentedPartyFactory
{
    /**
     * @param string $representedParty
     * @return XmlInjectable
     */
    public function fromStr(string $representedParty): XmlInjectable
    {
        $elements = [
            new ElementInjection(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'Header',
                new \DOMElement(
                    'representedParty',
                    '',
                    'http://x-road.eu/xsd/representation.xsd'
                )
            ),
        ];
        $parts = explode('/', $representedParty, 2);
        if (count($parts) > 1) {
            $elements[] = new ElementInjection(
                'http://x-road.eu/xsd/representation.xsd',
                'representedParty',
                new \DOMElement(
                    'partyClass',
                    array_shift($parts),
                    'http://x-road.eu/xsd/representation.xsd'
                )
            );
        }

        $elements[] = new ElementInjection(
            'http://x-road.eu/xsd/representation.xsd',
            'representedParty',
            new \DOMElement(
                'partyCode',
                array_shift($parts),
                'http://x-road.eu/xsd/representation.xsd'
            )
        );

        return XmlInjectionCollection::create(...$elements);
    }
}

<?php

namespace Raigu\XRoad\SoapEnvelope;

use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Traversable;

/**
 * I am the party who is represented by client.
 *
 * I know how to inject myself into SOAP envelope header.
 *
 * I fallow the specification "Third Party Representation Extension"
 * @see https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
 */
final class RepresentedParty extends AggregatedElement
{
    /**
     * RepresentedParty constructor.
     * @param Traversable $reference iterator over data describing represented
     *        party. Iterator must return key value pairs where key represents
     *        the tag name and value tag value in SOAP header.
     */
    public function __construct(Traversable $reference)
    {
        $elements = [
            new FragmentInjection(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'Header',
                '<repr:representedParty xmlns:repr="http://x-road.eu/xsd/representation.xsd"/>'
            ),
        ];

        foreach ($reference as $name => $value) {
            $elements[] = new DOMElementInjection(
                'http://x-road.eu/xsd/representation.xsd',
                'representedParty',
                new \DOMElement($name, $value, 'http://x-road.eu/xsd/representation.xsd')
            );
        }

        parent::__construct(...$elements);
    }
}

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
     * @param Traversable|array $reference associative array of data describing
     *        the party being represented by client. Data is embedded into
     *        proper place in SOAP Header. The key must be tag name and value
     *        tag value.
     */
    public function __construct($reference)
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

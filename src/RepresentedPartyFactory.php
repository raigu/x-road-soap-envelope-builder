<?php

namespace Raigu\XRoad\SoapEnvelope;

use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

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
        $fragment = ['<repr:representedParty xmlns:repr="http://x-road.eu/xsd/representation.xsd">'];

        $parts = explode('/', $representedParty, 2);

        if (count($parts) > 1) {
            $fragment[] = '<repr:partyClass>' . $parts[0] . '</repr:partyClass>';
            array_shift($parts);
        }

        $fragment[] = '<repr:partyCode>' . $parts[0] . '</repr:partyCode>';
        $fragment[] = '</repr:representedParty>';

        return new FragmentInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            implode('', $fragment)
        );
    }
}

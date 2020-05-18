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

    }
}

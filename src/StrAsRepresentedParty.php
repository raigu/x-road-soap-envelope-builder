<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

final class StrAsRepresentedParty implements XmlInjectable
{
    /**
     * @var XmlInjectable
     */
    private $injection;

    public function inject(DOMDocument $dom): void
    {
        $this->injection->inject($dom);
    }

    public function __construct(string $reference)
    {
        $fragment = ['<repr:representedParty xmlns:repr="http://x-road.eu/xsd/representation.xsd">'];

        $parts = explode('/', $reference, 2);

        if (count($parts) > 1) {
            $fragment[] = '<repr:partyClass>' . $parts[0] . '</repr:partyClass>';
            array_shift($parts);
        }

        $fragment[] = '<repr:partyCode>' . $parts[0] . '</repr:partyCode>';
        $fragment[] = '</repr:representedParty>';

        $this->injection = new FragmentInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            implode('', $fragment)
        );

    }
}

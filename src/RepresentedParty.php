<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;

final class RepresentedParty implements XmlInjectable
{
    /**
     * @var string
     */
    private $partyClass;
    /**
     * @var string
     */
    private $partyCode;

    public function inject(DOMDocument $dom)
    {
        $element = $dom->createElementNS(
            'http://x-road.eu/xsd/representation.xsd',
            'representedParty'
        );

        $element->appendChild(
            $dom->createElementNS(
                'http://x-road.eu/xsd/representation.xsd',
                'partyClass',
                $this->partyClass
            )
        );

        $element->appendChild(
            $dom->createElementNS(
                'http://x-road.eu/xsd/representation.xsd',
                'partyCode',
                $this->partyCode
            )
        );

        $elements = $dom->getElementsByTagNameNS(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header'
        );

        $elements->item(0)->appendChild($element);
    }

    public static function fromStr(string $value): self
    {
        [$partyClass, $partyCode] = explode('/', $value);

        return new self($partyClass, $partyCode);
    }

    private function __construct(string $partyClass, string $partyCode)
    {
        $this->partyClass = $partyClass;
        $this->partyCode = $partyCode;
    }
}

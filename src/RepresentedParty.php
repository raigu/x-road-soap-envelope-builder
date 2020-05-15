<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;

/**
 * I am a represented party element in X-Road SOAP request.
 * I follow technical specification https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
 */
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

        if ($this->partyClass !== '') {
            $element->appendChild(
                $dom->createElementNS(
                    'http://x-road.eu/xsd/representation.xsd',
                    'partyClass',
                    $this->partyClass
                )
            );
        }

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

    /**
     * @param string $value represented party data. partyClass is optional.
     *     format: [{partyClass}/]{partyCode}
     * @return static
     */
    public static function fromStr(string $value): self
    {
        $parts = explode('/', $value, 2);
        $partyClass = count($parts) == 2 ? $parts[0] : '';
        $partyCode = count($parts) == 2 ? $parts[1] : $parts[0];

        return new self($partyClass, $partyCode);
    }

    public static function create(string $partyClass, string $partyCode)
    {
        return new self($partyClass, $partyCode);
    }

    public static function fromCode(string $partyCode)
    {
        return new self('', $partyCode);
    }

    private function __construct(string $partyClass, string $partyCode)
    {
        $this->partyClass = $partyClass;
        $this->partyCode = $partyCode;
    }
}

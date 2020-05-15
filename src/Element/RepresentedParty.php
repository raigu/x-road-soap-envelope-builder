<?php

namespace Raigu\XRoad\SoapEnvelope\Element;

use DOMDocument;

/**
 * I am a represented party element in X-Road SOAP request.
 * I follow technical specification https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
 */
final class RepresentedParty implements XmlInjectable
{
    /**
     * @var XmlInjectable
     */
    private $partyClass;
    /**
     * @var XmlInjectable
     */
    private $partyCode;

    public function inject(DOMDocument $dom)
    {
        $elements = $dom->getElementsByTagNameNS(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header'
        );

        $elements->item(0)->appendChild(
            $dom->createElementNS(
                'http://x-road.eu/xsd/representation.xsd',
                'representedParty'
            )
        );

        $this->partyClass->inject($dom);
        $this->partyCode->inject($dom);
    }

    /**
     * @param string $value represented party data. partyClass is optional.
     *     format: [{partyClass}/]{partyCode}
     * @return static
     */
    public static function fromStr(string $value): self
    {
        $parts = explode('/', $value, 2);
        if (count($parts) === 2) {
            return self::create($parts[0], $parts[1]);
        } else {
            return self::fromCode($parts[0]);
        }
    }

    public static function create(string $partyClass, string $partyCode)
    {
        return new self(
            new ElementInjection(
                'http://x-road.eu/xsd/representation.xsd',
                'representedParty',
                new \DOMElement(
                    'partyClass',
                    $partyClass,
                    'http://x-road.eu/xsd/representation.xsd'
                )
            ),
            new ElementInjection(
                'http://x-road.eu/xsd/representation.xsd',
                'representedParty',
                new \DOMElement(
                    'partyCode',
                    $partyCode,
                    'http://x-road.eu/xsd/representation.xsd'
                )
            )
        );
    }

    public static function fromCode(string $partyCode)
    {
        return new self(
            new None(),
            new ElementInjection(
                'http://x-road.eu/xsd/representation.xsd',
                'representedParty',
                new \DOMElement(
                    'partyCode',
                    $partyCode,
                    'http://x-road.eu/xsd/representation.xsd'
                )
            )
        );
    }

    private function __construct(XmlInjectable $partyClass, XmlInjectable $partyCode)
    {
        $this->partyClass = $partyClass;
        $this->partyCode = $partyCode;
    }
}

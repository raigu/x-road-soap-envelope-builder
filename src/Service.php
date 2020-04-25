<?php

namespace Raigu\XRoad;

use DOMDocument;

/**
 * I am a service part of X-Road SOAP Envelope
 */
class Service implements XmlInjectable
{
    /**
     * @var array
     */
    private $values;

    public function inject(DOMDocument $dom)
    {
        $service = $dom->createElementNS(
            'http://x-road.eu/xsd/xroad.xsd',
            'service'
        );

        $objectType = $dom->createAttributeNS(
            'http://x-road.eu/xsd/identifiers',
            'objectType'
        );
        $objectType->value = 'SERVICE';
        $service->appendChild($objectType);

        $names = ['xRoadInstance', 'memberClass', 'memberCode', 'subsystemCode', 'serviceCode', 'serviceVersion'];

        foreach (array_combine($names, $this->values) as $name => $value) {
            $service->appendChild(
                $dom->createElementNS(
                    'http://x-road.eu/xsd/identifiers',
                    $name,
                    $value
                )
            );
        }

        $elements = $dom->getElementsByTagNameNS(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header'
        );

        $elements->item(0)->appendChild($service);
    }

    public static function fromStr(string $value): self
    {
        $values = explode('/', $value);
        if (count($values) !== 6) {
            throw new \Exception('Could not extract service parameters. Invalid format.');
        }
        return new self($values);
    }

    private function __construct(array $values)
    {
        $this->values = $values;
    }
}

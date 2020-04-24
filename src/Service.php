<?php

namespace Raigu\XRoad;

use DOMDocument;

/**
 * I am a service part of X-Road SOAP Envelope
 */
class Service implements XmlInjectable
{
    /**
     * @var string
     */
    private $value;

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
        $values = explode('/', $this->value);

        foreach (array_combine($names, $values) as $name => $value) {
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

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}

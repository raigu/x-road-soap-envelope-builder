<?php

namespace Raigu\XRoad;

use DOMDocument;

/**
 * I am a client part of X-Road SOAP Envelope
 */
class Client implements XmlInjectable
{
    /**
     * @var string
     */
    private $value;

    public function inject(DOMDocument $dom)
    {
        $client = $dom->createElementNS(
            'http://x-road.eu/xsd/xroad.xsd',
            'client'
        );

        $objectType = $dom->createAttributeNS(
            'http://x-road.eu/xsd/identifiers',
            'objectType'
        );
        $objectType->value = 'SUBSYSTEM';
        $client->appendChild($objectType);

        $names = ['xRoadInstance', 'memberClass', 'memberCode', 'subsystemCode'];
        $values = explode('/', $this->value);

        foreach (array_combine($names, $values) as $name => $value) {
            $client->appendChild(
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

        $elements->item(0)->appendChild($client);
    }

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}

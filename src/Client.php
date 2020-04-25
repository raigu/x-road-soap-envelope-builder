<?php

namespace Raigu\XRoad;

use DOMDocument;

/**
 * I am a client part of X-Road SOAP Envelope
 */
class Client implements XmlInjectable
{
    /**
     * @var array
     */
    private $values;

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


        foreach (array_combine($names, $this->values) as $name => $value) {
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

    public static function fromStr(string $value)
    {
        $values = explode('/', $value);
        return new self($values);
    }

    protected function __construct(array $values)
    {
        $this->values = $values;
    }
}

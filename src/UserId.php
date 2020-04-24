<?php

namespace Raigu\XRoad;

use DOMDocument;

class UserId implements XmlInjectable
{
    /**
     * @var string
     */
    private $value;

    public function inject(DOMDocument $dom)
    {
        $elements = $dom->getElementsByTagNameNS(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header'
        );

        $elements->item(0)->appendChild(
            $dom->createElementNS(
                'http://x-road.eu/xsd/xroad.xsd',
                'userId',
                $this->value
            )
        );
    }

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}

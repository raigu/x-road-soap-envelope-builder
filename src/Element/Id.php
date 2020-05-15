<?php

namespace Raigu\XRoad\SoapEnvelope\Element;

use DOMDocument;

/**
 * I am a X-Road request unique identification.
 */
class Id implements XmlInjectable
{
    public function inject(DOMDocument $dom)
    {
        $elements = $dom->getElementsByTagNameNS(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header'
        );

        $elements->item(0)->appendChild(
            $dom->createElementNS(
                'http://x-road.eu/xsd/xroad.xsd',
                'id',
                bin2hex(random_bytes(16))
            )
        );
    }

    public static function random(): self
    {
        return new self();
    }

    protected function __construct()
    {
    }
}

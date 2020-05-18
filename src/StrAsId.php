<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I am a X-Request id.
 *
 * I can inject myself into SOAP envelope header
 */
final class StrAsId implements XmlInjectable
{
    /**
     * @var XmlInjectable
     */
    private $injection;

    public function inject(DOMDocument $dom): void
    {
        $this->injection->inject($dom);
    }

    public function __construct(string $id)
    {
        $this->injection = new DOMElementInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            new \DOMElement(
                'id',
                $id,
                'http://x-road.eu/xsd/xroad.xsd'
            )
        );
    }
}

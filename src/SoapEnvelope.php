<?php

namespace Raigu\XRoad\SoapEnvelope;

use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I am a SOAP Envelope.
 *
 * I can return myself as string
 */
final class SoapEnvelope
{
    /**
     * @var XmlInjectable[]
     */
    private $elements;

    /**
     * Return SOAP envelope
     *
     * @return string
     */
    public function asStr(): string
    {
        $envelope = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" 
                   xmlns:id="http://x-road.eu/xsd/identifiers"
                   xmlns:xrd="http://x-road.eu/xsd/xroad.xsd">
    <env:Header/>
    <env:Body/>
</env:Envelope>
EOD;

        $dom = new \DOMDocument();
        $dom->loadXML($envelope);

        foreach ($this->elements as $element) {
            $element->inject($dom);
        }

        return $dom->saveXML();
    }

    /**
     * @param XmlInjectable[] $elements
     */
    public function __construct(XmlInjectable ...$elements)
    {
        $this->elements = $elements;

        $this->elements[] = new DOMElementInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            new \DOMElement(
                'protocolVersion',
                '4.0',
                'http://x-road.eu/xsd/xroad.xsd'
            )
        );
    }
}

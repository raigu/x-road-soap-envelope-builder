<?php

namespace Raigu\XRoad\SoapEnvelope;

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
    <env:Header>
        <xrd:protocolVersion>4.0</xrd:protocolVersion>
    </env:Header>
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

    public static function create(XmlInjectable ...$elements)
    {
        return new self(...$elements);
    }

    private function __construct(XmlInjectable ...$elements)
    {
        $this->elements = $elements;
    }


}

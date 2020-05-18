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
final class Id implements XmlInjectable
{
    /**
     * @var XmlInjectable
     */
    private $element;

    public function inject(DOMDocument $dom): void
    {
        $this->element->inject($dom);
    }

    /**
     * @param string $id Unique identifier of X-Road message.
     *             According to the specification recommended
     *             form of message id is UUID.
     * @see https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#22-message-headers
     */
    public function __construct(string $id)
    {
        $this->element = new DOMElementInjection(
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

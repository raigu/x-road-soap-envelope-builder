<?php

namespace Raigu\XRoad\SoapEnvelope;

/**
 * I am a X-Request id.
 *
 * I can inject myself into SOAP envelope header
 */
final class Id extends DOMElementAsSoapHeaderElement
{
    /**
     * @param string $id Unique identifier of X-Road message.
     *             According to the specification recommended
     *             form of message id is UUID.
     * @see https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#22-message-headers
     */
    public function __construct(string $id)
    {
        parent::__construct(
            new \DOMElement(
                'id',
                $id,
                'http://x-road.eu/xsd/xroad.xsd'
            )
        );
    }
}

<?php

namespace Raigu\XRoad\SoapEnvelope;

/**
 * I am an issue reference number of X-Road message
 *
 * I can inject myself into SOAP envelope header
 */
final class Issue extends DOMElementAsSoapHeaderElement
{
    /**
     * @param string $issue Identifies received application, issue or document
     *                      that was the cause of the service request. This
     *                      field may be used by the client information system
     *                      to connect service requests (and responses) to
     *                      working procedures.
     */
    public function __construct(string $issue)
    {
        parent::__construct(
            new \DOMElement(
                'issue',
                $issue,
                'http://x-road.eu/xsd/xroad.xsd'
            )
        );
    }
}

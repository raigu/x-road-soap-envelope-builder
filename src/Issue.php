<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I am an issue reference number of X-Road message
 *
 * I can inject myself into SOAP envelope header
 */
final class Issue implements XmlInjectable
{
    /**
     * @var DOMElementInjection
     */
    private $element;

    public function inject(DOMDocument $dom): void
    {
        $this->element->inject($dom);
    }

    public function __construct(string $issue)
    {
        $this->element = new DOMElementInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            new \DOMElement(
                'issue',
                $issue,
                'http://x-road.eu/xsd/xroad.xsd'
            )
        );
    }
}

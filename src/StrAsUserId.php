<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I am an user id of the person who initiates the X-Road request.
 *
 * I can inject myself into SOAP envelope header
 */
final class StrAsUserId implements XmlInjectable
{
    /**
     * @var XmlInjectable
     */
    private $element;

    public function inject(DOMDocument $dom): void
    {
        $this->element->inject($dom);
    }

    public function __construct(string $userId)
    {
        $this->element = new DOMElementInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            new \DOMElement(
                'userId',
                (new ValidatedUserId($userId))->asStr(),
                'http://x-road.eu/xsd/xroad.xsd'
            )
        );
    }
}

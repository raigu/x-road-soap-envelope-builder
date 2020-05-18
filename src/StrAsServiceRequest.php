<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I am a request of an X-Road service.
 *
 * I can inject myself into SOAP Envelope Body.
 */
final class StrAsServiceRequest implements XmlInjectable
{
    /**
     * @var XmlInjectable
     */
    private $element;

    public function inject(DOMDocument $dom): void
    {
        $this->element->inject($dom);
    }

    public function __construct(string $serviceRequest)
    {
        $this->element = new FragmentInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Body',
            $serviceRequest
        );
    }
}

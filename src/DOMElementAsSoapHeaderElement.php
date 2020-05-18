<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use DOMElement;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I DOMElement of SOAP Header.
 *
 * I know how to inject myself into SOAP Header
 */
abstract class DOMElementAsSoapHeaderElement implements XmlInjectable
{
    /**
     * @var DOMElement
     */
    private $element;

    public function inject(DOMDocument $dom): void
    {
        $this->element->inject($dom);
    }

    public function __construct(DOMElement $element)
    {
        $this->element = new DOMElementInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            $element
        );
    }
}

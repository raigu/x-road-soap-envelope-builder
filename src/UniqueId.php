<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I am a X-Request id.
 *
 * I assign a random id to myself upon creation.
 * I can inject myself into SOAP envelope header
 */
final class UniqueId implements XmlInjectable
{
    /**
     * @var XmlInjectable
     */
    private $element;

    public function inject(DOMDocument $dom): void
    {
        $this->element->inject($dom);
    }


    public function __construct()
    {
        $this->element = new Id(
            bin2hex(random_bytes(16))
        );
    }
}

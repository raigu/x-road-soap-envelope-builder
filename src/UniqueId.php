<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

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

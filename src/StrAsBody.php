<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

final class StrAsBody implements XmlInjectable
{
    /**
     * @var XmlInjectable
     */
    private $injection;

    public function inject(DOMDocument $dom): void
    {
        $this->injection->inject($dom);
    }

    public function __construct(string $serviceRequest)
    {
        $this->injection = new FragmentInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Body',
            $serviceRequest
        );
    }
}

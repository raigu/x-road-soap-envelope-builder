<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

final class StrAsIssue implements XmlInjectable
{
    /**
     * @var DOMElementInjection
     */
    private $injection;

    public function inject(DOMDocument $dom): void
    {
        $this->injection->inject($dom);
    }

    public function __construct(string $issue)
    {
        $this->injection = new DOMElementInjection(
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

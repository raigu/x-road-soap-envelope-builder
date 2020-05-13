<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;

/**
 * I am a body content of X-Road SOAP Envelope
 */
class BodyContent implements XmlInjectable
{
    /**
     * @var string
     */
    private $content;

    public function inject(DOMDocument $dom)
    {
        $elements = $dom->getElementsByTagNameNS(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Body'
        );

        $body = $elements->item(0);

        while ($body->hasChildNodes()) {
            $body->removeChild($body->firstChild);
        }

        $fragment = $dom->createDocumentFragment();
        $fragment->appendXML($this->content);

        $body->appendChild($fragment);
    }


    public function __construct(string $content)
    {
        $this->content = $content;
    }
}

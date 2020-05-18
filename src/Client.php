<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;
use Traversable;

/**
 * I am a client who makes X-Road request
 *
 * I can inject myself into SOAP envelope header
 */
final class Client implements XmlInjectable
{
    /**
     * @var XmlInjectable[]
     */
    private $injections;

    public function inject(DOMDocument $dom): void
    {
        foreach ($this->injections as $injection) {
            $injection->inject($dom);
        }
    }

    /**
     * @param Traversable $reference iterator over data describing client
     *        who is making the X-Road request. Iterator must return key value
     *        pairs where key represents the tag name and value tag value in
     *        SOAP header.
     */
    public function __construct(Traversable $reference)
    {
        $this->injections = [
            new FragmentInjection(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'Header',
                '<xrd:client xmlns:xrd="http://x-road.eu/xsd/xroad.xsd" ' .
                'xmlns:id="http://x-road.eu/xsd/identifiers" ' .
                'id:objectType="SUBSYSTEM"/>'
            ),
        ];

        foreach ($reference as $name => $value) {
            $this->injections[] = new DOMElementInjection(
                'http://x-road.eu/xsd/xroad.xsd',
                'client',
                new \DOMElement($name, $value, 'http://x-road.eu/xsd/identifiers')
            );
        }
    }
}

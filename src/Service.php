<?php

namespace Raigu\XRoad\SoapEnvelope;

use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Traversable;

/**
 * I am a service of X-Road
 *
 * I can inject myself into SOAP envelope header
 */
final class Service extends AggregatedElement
{

    /**
     * @param Traversable|array $reference associative array of data describing
     *        what service is requested. Data is embedded into proper place in
     *        SOAP Header. The key must be tag name and value tag value.
     */
    public function __construct($reference)
    {
        $elements = [
            new FragmentInjection(
                'http://schemas.xmlsoap.org/soap/envelope/',
                'Header',
                '<xrd:service xmlns:xrd="http://x-road.eu/xsd/xroad.xsd" ' .
                'xmlns:id="http://x-road.eu/xsd/identifiers" ' .
                'id:objectType="SERVICE"/>'
            ),
        ];


        foreach ($reference as $name => $value) {
            $elements[] = new DOMElementInjection(
                'http://x-road.eu/xsd/xroad.xsd',
                'service',
                new \DOMElement($name, $value, 'http://x-road.eu/xsd/identifiers')
            );
        }

        parent::__construct(...$elements);
    }
}

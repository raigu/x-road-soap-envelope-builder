<?php

namespace Raigu\XRoad\SoapEnvelope;

use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I create a service element of X-Road SOAP envelope
 * which can inject itself into proper place in DOMDocument
 */
final class ClientFactory
{
/**
     * @param string $reference
     * @return XmlInjectable
     */
    public function fromStr(string $reference): XmlInjectable
    {
        $parts = explode('/', $reference);
        if (count($parts) !== 4) {
            throw new \Exception('Could not extract service parameters. Invalid format.');
        }

        $fragment = <<<EOD
<xrd:client id:objectType="SUBSYSTEM" 
    xmlns:xrd="http://x-road.eu/xsd/xroad.xsd"
    xmlns:id="http://x-road.eu/xsd/identifiers">
            <id:xRoadInstance>{$parts[0]}</id:xRoadInstance>
            <id:memberClass>{$parts[1]}</id:memberClass>
            <id:memberCode>{$parts[2]}</id:memberCode>
            <id:subsystemCode>{$parts[3]}</id:subsystemCode>
</xrd:client>
EOD;

        return new FragmentInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            $fragment
        );
    }
}

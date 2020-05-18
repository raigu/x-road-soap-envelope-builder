<?php

namespace Raigu\XRoad\SoapEnvelope;

use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

/**
 * I am factory of X-Road SOAP Envelope elements.
 */
final class XRoadSoapMessageElementsFactory
{
    /**
     * @param string $reference encoded service.
     *                   Format: {xRoadInstance}/{memberClass/{memberCode}/{subsystemCode}/{serviceCode}/{serviceVerson}
     *                   Example: EE/GOV/70000310/DHX.Riigi-Teataja/sendDocument/v1
     * @return XmlInjectable
     */
    public function service(string $reference): XmlInjectable
    {
        return (new ServiceFactory())->fromStr($reference);
    }

    /**
     * @param string $reference encoded client.
     *                   Format: {xRoadInstance}/{memberClass/{memberCode}/{subsystemCode}
     *                   Example: EE/COM/00000000/sys
     * @return XmlInjectable
     */
    public function client(string $reference): XmlInjectable
    {
        return (new ClientFactory)->fromStr($reference);
    }

    /**
     * @param string $serviceRequest service request
     * @return XmlInjectable
     */
    public function body(string $serviceRequest): XmlInjectable
    {

    }

    /**
     * @param string $userId the user who is making the request
     *                   Format: {iso2LetterCountryCode}{personCode}
     *                   Example: EE0000000000
     * @return XmlInjectable
     */
    public function userId(string $userId): XmlInjectable
    {
        return new DOMElementInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            new \DOMElement(
                'userId',
                (new ValidatedUserId($userId))->asStr(),
                'http://x-road.eu/xsd/xroad.xsd'
            )
        );
    }

    /**
     * @see https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
     * @param string $reference string representing representative party. format: [{partyClass}/]{partyCode}
     *      String is concatenation of represented party class (optional) and code in separated by /.
     * @return XmlInjectable
     */
    public static function representedParty(string $reference): XmlInjectable
    {
        return (new RepresentedPartyFactory)->fromStr($reference);
    }

}

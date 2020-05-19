<?php

namespace Raigu\XRoad\SoapEnvelope;

use Raigu\XRoad\SoapEnvelope\Element\DeferredFragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\DOMElementInjection;
use Raigu\XRoad\SoapEnvelope\Element\FragmentInjection;
use Raigu\XRoad\SoapEnvelope\Element\UnInitialized;

final class SoapEnvelopeBuilder
{
    /**
     * @var array
     */
    private $elements;

    /**
     * Clone builder and replace service in SOAP header
     *
     * @param string $service encoded service.
     *                   Format: {xRoadInstance}/{memberClass/{memberCode}/{subsystemCode}/{serviceCode}/{serviceVerson}
     *                   Example: EE/GOV/70000310/DHX.Riigi-Teataja/sendDocument/v1
     * @return self cloned builder with overwritten service data
     */
    public function withService(string $service): self
    {
        $elements = $this->elements;
        $elements['service'] = (new ServiceFactory())->fromStr($service);

        return new self($elements);
    }

    /**
     * Clone builder and replace client in SOAP header
     *
     * @param string $client encoded client.
     *                   Format: {xRoadInstance}/{memberClass/{memberCode}/{subsystemCode}
     *                   Example: EE/COM/00000000/sys
     * @return self cloned builder with overwritten client data
     */
    public function withClient(string $client): self
    {
        $elements = $this->elements;
        $elements['client'] = (new ClientFactory)->fromStr($client);

        return new self($elements);
    }

    /**
     * Clone builder and replace userId in SOAP header
     *
     * @param string $userId the user who is making the request
     *                   Format: {iso2LetterCountryCode}{personCode}
     *                   Example: EE0000000000
     * @return self cloned builder with overwritten client data
     */
    public function withUserId(string $userId): self
    {
        $elements = $this->elements;
        $elements['userId'] = new DOMElementInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            new \DOMElement(
                'userId',
                (new ValidatedUserId($userId))->asStr(),
                'http://x-road.eu/xsd/xroad.xsd'
            )
        );

        return new self($elements);
    }

    /**
     * Clone builder and replace SOAP body
     * @param string $body content of SOAP Body tag.
     * @return self
     */
    public function withBody(string $body): self
    {
        $elements = $this->elements;
        $elements['body'] = new FragmentInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Body',
            $body
        );

        return new self($elements);
    }

    /**
     * Clone builder and replace representedParty in SOAP header.
     * @see https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
     * @param string $representedParty string representing representative party. format: [{partyClass}/]{partyCode}
     *      String is concatenation of represented party class (optional) and code in separated by /.
     * @return $this
     */
    public function withRepresentedParty(string $representedParty): self
    {
        $elements = $this->elements;
        $elements['representedParty'] = (new RepresentedPartyFactory)->fromStr($representedParty);

        return new self($elements);
    }

    public function build(): string
    {
        $envelope = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" 
                   xmlns:id="http://x-road.eu/xsd/identifiers"
                   xmlns:xrd="http://x-road.eu/xsd/xroad.xsd">
    <env:Header>
        <xrd:protocolVersion>4.0</xrd:protocolVersion>
    </env:Header>
    <env:Body/>
</env:Envelope>
EOD;

        $dom = new \DOMDocument();
        $dom->loadXML($envelope);

        foreach ($this->elements as $element) {
            $element->inject($dom);
        }

        return $dom->saveXML();
    }

    public static function create(): self
    {
        return new self([
                'service' => new UnInitialized('Service not initialized'),
                'client' => new UnInitialized('Client not initialized'),
                'body' => new UnInitialized('Body not initialized'),
            ]
        );
    }

    public static function stub(): self
    {
        return self::create()
            ->withService('EE/COM/11111111/PROVIDER_SYS/provider_method/v99')
            ->withClient('EE/COM/22222222/CLIENT_SYS')
            ->withBody('<stub xmlns="https://stub.ee"></stub>');
    }

    private function __construct(array $elements)
    {
        $this->elements = $elements;
        $this->elements['id'] = new DeferredFragmentInjection(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header',
            function (): string {
                return sprintf(
                    '<xrd:id xmlns:xrd="http://x-road.eu/xsd/xroad.xsd">%s</xrd:id>',
                    bin2hex(random_bytes(16))
                );
            }
        );
    }
}

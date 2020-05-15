<?php

namespace Raigu\XRoad\SoapEnvelope;

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
        $elements['service'] = Service::fromStr($service);

        return new self($elements);
    }

    /**
     * Clone builder and replace client in SOAP header
     *
     * @param string $service encoded service.
     *                   Format: {xRoadInstance}/{memberClass/{memberCode}/{subsystemCode}
     *                   Example: EE/COM/00000000/sys
     * @return self cloned builder with overwritten client data
     */
    public function withClient(string $client): self
    {
        $elements = $this->elements;
        $elements['client'] = Client::fromStr($client);

        return new self($elements);
    }

     /**
     * Clone builder and replace userId in SOAP header
     *
     * @param string $userId the
     *                   Format: {xRoadInstance}/{memberClass/{memberCode}/{subsystemCode}
     *                   Example: EE/COM/00000000/sys
     * @return self cloned builder with overwritten client data
     */
    public function withUserId(string $userId): self
    {
        $elements = $this->elements;
        $elements['userId'] = UserId::fromStr($userId);

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
        $elements['body'] = new BodyContent($body);

        return new self($elements);
    }

    public function build(): string
    {
        $envelope = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
                   xmlns:id="http://x-road.eu/xsd/identifiers"
                   xmlns:xrd="http://x-road.eu/xsd/xroad.xsd">
    <SOAP-ENV:Header>
        <xrd:protocolVersion>4.0</xrd:protocolVersion>
    </SOAP-ENV:Header>
    <SOAP-ENV:Body>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
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
                'userId' => new None,
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
        $this->elements['id'] = Id::random();
    }
}

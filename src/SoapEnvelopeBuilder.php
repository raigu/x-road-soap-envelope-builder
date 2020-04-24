<?php

namespace Raigu\XRoad;

final class SoapEnvelopeBuilder
{
    /**
     * @var string
     */
    private $service;
    /**
     * @var string
     */
    private $body;
    /**
     * @var string
     */
    private $client;
    /**
     * @var string
     */
    private $userId;

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
        return new self($service, $this->client, $this->body, $this->userId);
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
        return new self($this->service, $client, $this->body, $this->userId);
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
        return new self($this->service, $this->client, $this->body, $userId);
    }

    /**
     * Clone builder and replace SOAP body
     * @param string $body content of SOAP Body tag.
     * @return self
     */
    public function withBody(string $body): self
    {
        return new self($this->service, $this->client, $body, $this->userId);
    }

    public function build(): string
    {
        $service = explode('/', $this->service);
        $client = explode('/', $this->client);
        $id = bin2hex(random_bytes(16));
        $userIdTag = empty($this->userId) ? '' : '<xrd:userId>'.$this->userId.'</xrd:userId>';

        // source of response template: https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#e1-request
        $envelope = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
        xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:xrd="http://x-road.eu/xsd/xroad.xsd"
        xmlns:id="http://x-road.eu/xsd/identifiers">
    <SOAP-ENV:Header>
        <xrd:client id:objectType="SUBSYSTEM">
            <id:xRoadInstance>{$client[0]}</id:xRoadInstance>
            <id:memberClass>{$client[1]}</id:memberClass>
            <id:memberCode>{$client[2]}</id:memberCode>
            <id:subsystemCode>{$client[3]}</id:subsystemCode>
        </xrd:client>
        <xrd:service id:objectType="SERVICE">
            <id:xRoadInstance>{$service[0]}</id:xRoadInstance>
            <id:memberClass>{$service[1]}</id:memberClass>
            <id:memberCode>{$service[2]}</id:memberCode>
            <id:subsystemCode>{$service[3]}</id:subsystemCode>
            <id:serviceCode>{$service[4]}</id:serviceCode>
            <id:serviceVersion>{$service[5]}</id:serviceVersion>
        </xrd:service>
        <xrd:id>{$id}</xrd:id>
        {$userIdTag}
        <xrd:issue>12345</xrd:issue>
        <xrd:protocolVersion>4.0</xrd:protocolVersion>
    </SOAP-ENV:Header>
    <SOAP-ENV:Body>
        {$this->body} 
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
EOD;

        return $envelope;
    }

    public static function create(): self
    {
        return new self('/////', '///', '', '');
    }

    private function __construct(string $service, string $client, string $body, string $userId)
    {
        $this->service = $service;
        $this->body = $body;
        $this->client = $client;
        $this->userId = $userId;
    }
}

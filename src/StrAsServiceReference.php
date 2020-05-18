<?php

namespace Raigu\XRoad\SoapEnvelope;

final class StrAsServiceReference implements XRoadMember, XRoadService
{
    /**
     * @var array
     */
    private $parts;

    public function xRoadInstance(): string
    {
        return $this->parts[0];
    }

    public function memberClass(): string
    {
        return $this->parts[1];
    }

    public function memberCode(): string
    {
        return $this->parts[2];
    }

    public function subSystemCode(): string
    {
        return $this->parts[3];
    }

    public function serviceCode(): string
    {
        return $this->parts[4];
    }

    public function serviceVersion(): string
    {
        return $this->parts[5];
    }

    public function __construct(string $reference)
    {
        $parts = explode('/', $reference);
        if (count($parts) !== 6) {
            throw new \Exception('Could not extract service parameters. Invalid format.');
        }

        return $this->parts = $parts;
    }

}

<?php

namespace Raigu\XRoad\SoapEnvelope;

final class StrAsClientReference implements XRoadMember
{
    /**
     * @var string[]
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

    public function __construct(string $reference)
    {
        $parts = explode('/', $reference);
        if (count($parts) !== 4) {
            throw new \Exception('Could not extract client parameters. Invalid format.');
        }

        $this->parts = $parts;
    }
}

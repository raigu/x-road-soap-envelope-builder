<?php

namespace Raigu\XRoad\SoapEnvelope;

use IteratorAggregate;

final class RepresentedPartyReference implements IteratorAggregate
{
    /**
     * @var string[]
     */
    private $parts;

    public function getIterator()
    {
        if (count($this->parts) == 2) {
            yield 'partyClass' => $this->parts[0];
        }

        yield 'partyCode' => $this->parts[count($this->parts)-1];
    }

    public function __construct(string $reference)
    {
        $this->parts = explode('/', $reference, 2);
    }
}

<?php

namespace Raigu\XRoad\SoapEnvelope;

use IteratorAggregate;

/**
 * I am a reference of a Client in string format acting as an iterator.
 *
 * I expose name and value used in SOAP envelope.
 */
final class ClientReference implements IteratorAggregate
{
    /**
     * @var string[]
     */
    private $parts;

    public function getIterator()
    {
        yield from array_combine(
            [
                'xRoadInstance',
                'memberClass',
                'memberCode',
                'subsystemCode',
            ],
            $this->parts
        );
    }

    /**
     * @param string $reference reference to the client.
     *                   Format: {xRoadInstance}/{memberClass/{memberCode}/{subsystemCode}
     *                   Example: EE/COM/00000000/sys
     */
    public function __construct(string $reference)
    {
        $parts = explode('/', $reference);
        if (count($parts) !== 4) {
            throw new \Exception('Could not extract client parameters. Invalid format.');
        }

        $this->parts = $parts;
    }
}

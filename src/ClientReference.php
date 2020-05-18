<?php

namespace Raigu\XRoad\SoapEnvelope;

use IteratorAggregate;

/**
 * I am a string acting as X-Road Client Reference
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

    public function __construct(string $reference)
    {
        $parts = explode('/', $reference);
        if (count($parts) !== 4) {
            throw new \Exception('Could not extract client parameters. Invalid format.');
        }

        $this->parts = $parts;
    }
}

<?php

namespace Raigu\XRoad\SoapEnvelope;

final class ServiceReference implements \IteratorAggregate
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
                'serviceCode',
                'serviceVersion',
            ],
            $this->parts
        );
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

<?php

namespace Raigu\XRoad\SoapEnvelope;

/**
 * I am a reference of a service in string format acting as an iterator.
 *
 * I expose name and value used in SOAP envelope.
 */
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

    /**
     * @param string $reference reference to the serice.
     *                   Format: {xRoadInstance}/{memberClass/{memberCode}/{subsystemCode}/{serviceCode}/{serviceVerson}
     *                   Example: EE/GOV/70000310/DHX.Riigi-Teataja/sendDocument/v1
     */
    public function __construct(string $reference)
    {
        $parts = explode('/', $reference);
        if (count($parts) !== 6) {
            throw new \Exception('Could not extract service parameters. Invalid format.');
        }

        return $this->parts = $parts;
    }
}

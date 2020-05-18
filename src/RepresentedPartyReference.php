<?php

namespace Raigu\XRoad\SoapEnvelope;

use IteratorAggregate;

/**
 * I am a reference of a represented party in string format acting as an iterator.
 *
 * I expose name and value used in SOAP envelope.
 *
 * Represented party is the party on behalf of whom the client makes requests.
 * @see https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
 */
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

    /**
     * @see https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html
     * @param string $reference reference of a party who is represented by client.
     *       format: [{partyClass}/]{partyCode}
     * @param string $reference
     */
    public function __construct(string $reference)
    {
        $this->parts = explode('/', $reference, 2);
    }
}

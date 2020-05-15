<?php

namespace Raigu\XRoad\SoapEnvelope;

use IteratorAggregate;

/**
 * I am a service reference which can represent itself as node elements in X-Road SOAP message.
 */
final class ServiceReferenceAsArray implements IteratorAggregate
{
    /**
     * @var array
     */
    private $values;

    public function getIterator()
    {
        $names = ['xRoadInstance', 'memberClass', 'memberCode', 'subsystemCode', 'serviceCode', 'serviceVersion'];
        for ($i=0; $i < count($names); $i++) {
            yield $names[$i] => $this->values[$i];
        }
    }

    public static function create(string $serviceReference): self
    {
        return new self(explode('/', $serviceReference));
    }

    private function __construct(array $values)
    {
        $this->values = $values;
    }
}

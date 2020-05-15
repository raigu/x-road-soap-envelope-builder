<?php

namespace Raigu\XRoad\SoapEnvelope\Element;

use DOMDocument;

final class XmlInjectionCollection implements XmlInjectable
{
    /**
     * @var XmlInjectable[]
     */
    private $injections;

    public function inject(DOMDocument $dom)
    {
        foreach ($this->injections as $injection) {
            $injection->inject($dom);
        }
    }

    public static function create(XmlInjectable ...$injections): self
    {
        return new self(...$injections);
    }

    private function __construct(XmlInjectable ...$injections)
    {
        $this->injections = $injections;
    }
}

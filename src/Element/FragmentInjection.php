<?php

namespace Raigu\XRoad\SoapEnvelope\Element;

use DOMDocument;

/**
 * I append XML fragment as child to referred node.
 */
final class FragmentInjection implements XmlInjectable
{
    /**
     * @var DeferredFragmentInjection
     */
    private $injection;

    public function inject(DOMDocument $dom)
    {
        $this->injection->inject($dom);
    }

    public function __construct(string $parentNS, string $parentTagName, string $fragment)
    {
        $this->injection = new DeferredFragmentInjection(
            $parentNS,
            $parentTagName,
            function () use ($fragment): string {
                return $fragment;
            }
        );
    }
}

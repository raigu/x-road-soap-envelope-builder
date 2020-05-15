<?php

namespace Raigu\XRoad\SoapEnvelope\Element;

use DOMDocument;
use DOMElement;

final class FragmentInjection implements XmlInjectable
{
    /**
     * @var string
     */
    private $parentNS;
    /**
     * @var string
     */
    private $parentTagName;
    /**
     * @var string
     */
    private $fragment;

    public function inject(DOMDocument $dom)
    {
        $elements = $dom->getElementsByTagNameNS($this->parentNS, $this->parentTagName);

        $fragment = $dom->createDocumentFragment();
        $fragment->appendXML($this->fragment);

        $elements->item(0)->appendChild($fragment);
    }

    public static function create(string $parentNS, string $parentTagName, string $fragment): self
    {
        return new self($parentNS, $parentTagName, $fragment);
    }

    private function __construct(string $parentNS, string $parentTagName, string $fragment)
    {
        $this->parentNS = $parentNS;
        $this->parentTagName = $parentTagName;
        $this->fragment = $fragment;
    }
}

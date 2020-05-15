<?php

namespace Raigu\XRoad\SoapEnvelope\Element;

use DOMDocument;
use DOMElement;

/**
 * I append DOMElement as child to referred node.
 */
final class DOMElementInjection implements XmlInjectable
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
     * @var DOMElement
     */
    private $child;

    public function inject(DOMDocument $dom): void
    {
        $elements = $dom->getElementsByTagNameNS($this->parentNS, $this->parentTagName);
        $elements->item(0)->appendChild($this->child);
    }

    public function __construct(string $parentNS, string $parentTagName, DOMElement $child)
    {
        $this->parentNS = $parentNS;
        $this->parentTagName = $parentTagName;
        $this->child = $child;
    }
}

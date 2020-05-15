<?php

namespace Raigu\XRoad\SoapEnvelope\Element;

use Closure;
use DOMDocument;

/**
 * I defer fragment creation to the last moment before injection.
 */
final class DeferredFragmentInjection implements XmlInjectable
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
     * @var Closure
     */
    private $fragment;

    public function inject(DOMDocument $dom)
    {
        $elements = $dom->getElementsByTagNameNS($this->parentNS, $this->parentTagName);

        $fragment = $dom->createDocumentFragment();
        $fragment->appendXML(call_user_func($this->fragment));

        $elements->item(0)->appendChild($fragment);
    }

    public function __construct(string $parentNS, string $parentTagName, Closure $fragment)
    {
        $this->parentNS = $parentNS;
        $this->parentTagName = $parentTagName;
        $this->fragment = $fragment;
    }
}

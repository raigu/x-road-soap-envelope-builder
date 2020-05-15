<?php

namespace Raigu\XRoad\SoapEnvelope\Element;

use Closure;
use DOMDocument;

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

    public static function fromClosure(string $parentNS, string $parentTagName, Closure $fragment)
    {
        return new self($parentNS, $parentTagName, $fragment);
    }

    public static function create(string $parentNS, string $parentTagName, string $fragment): self
    {
        return self::fromClosure($parentNS, $parentTagName, function () use ($fragment): string {
            return $fragment;
        });
    }

    private function __construct(string $parentNS, string $parentTagName, Closure $fragment)
    {
        $this->parentNS = $parentNS;
        $this->parentTagName = $parentTagName;
        $this->fragment = $fragment;
    }
}

<?php

namespace Raigu\XRoad;

use DOMDocument;
use Exception;

/**
 * I am an uninitialized element.
 * I will throw an exception if injected into XML
 */
class UnInitialized implements XmlInjectable
{
    /**
     * @var string
     */
    private $message;

    public function inject(DOMDocument $dom)
    {
        throw new Exception($this->message);
    }


    public function __construct(string $message)
    {
        $this->message = $message;
    }
}

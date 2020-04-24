<?php

namespace Raigu\XRoad;

use DOMDocument;

/**
 * I am none element.
 * I inject nothing into XML
 */
class None implements XmlInjectable
{
    public function inject(DOMDocument $dom)
    {
    }
}

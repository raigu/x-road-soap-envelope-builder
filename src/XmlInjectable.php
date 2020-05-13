<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;

/**
 * I know how to inject myself into proper place in XML
 */
interface XmlInjectable
{
    public function inject(DOMDocument $dom);
}

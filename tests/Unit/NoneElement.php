<?php

namespace Raigu\XRoad\SoapEnvelope;

use DOMDocument;
use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

final class NoneElement implements XmlInjectable
{
    public function inject(DOMDocument $dom): void
    {

    }
}

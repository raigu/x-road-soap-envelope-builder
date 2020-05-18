<?php

namespace Raigu\XRoad\SoapEnvelope;

use Raigu\XRoad\SoapEnvelope\Element\XmlInjectable;

final class Client implements XmlInjectable
{
    public function __construct(ClientReference $reference)
    {
    }
}

<?php

namespace Raigu\XRoad\SoapEnvelope;

use PHPUnit\Framework\TestCase;

class ServiceValidationTest extends TestCase
{
    /**
     * @test
     */
    public function fromStr_throws_exception_when_invalid_format()
    {
        $this->expectExceptionMessage('Invalid format');

        new StrAsServiceReference('');
    }
}

<?php

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelope\ServiceFactory;

class ServiceValidationTest extends TestCase
{
    /**
     * @test
     */
    public function fromStr_throws_exception_when_invalid_format()
    {
        $this->expectExceptionMessage('Invalid format');
        (new ServiceFactory)->fromStr('');
    }
}

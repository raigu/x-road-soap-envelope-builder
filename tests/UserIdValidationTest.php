<?php

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelope\UserId;

class UserIdValidationTest extends TestCase
{
    /**
     * @test
     */
    public function fromStr_throws_exception_if_country_code_prefix_missing()
    {
        $this->expectExceptionMessage('country code');
        UserId::fromStr('00000000000');
    }
}

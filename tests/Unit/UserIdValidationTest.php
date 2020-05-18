<?php

namespace Raigu\XRoad\SoapEnvelope;

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\SoapEnvelope\ValidatedUserId as ValidatedUserIdAlias;

class UserIdValidationTest extends TestCase
{
    /**
     * @test
     */
    public function fromStr_throws_exception_if_country_code_prefix_missing()
    {
        $this->expectExceptionMessage('country code');
        $sut = new ValidatedUserIdAlias('00000000000');
        $sut->asStr();
    }
}

<?php


namespace Raigu\XRoad\SoapEnvelope;

/**
 * I am a X-Road Member description
 */
interface XRoadMember
{
    public function xRoadInstance(): string;

    public function memberClass(): string;

    public function memberCode(): string;

    public function subSystemCode(): string;
}
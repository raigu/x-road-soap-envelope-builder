<?php


namespace Raigu\XRoad\SoapEnvelope;


interface XRoadMember
{
    public function xRoadInstance(): string;

    public function memberClass(): string;

    public function memberCode(): string;

    public function subSystemCode(): string;
}
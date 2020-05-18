<?php


namespace Raigu\XRoad\SoapEnvelope;


interface XRoadService
{
    public function serviceCode(): string;

    public function serviceVersion(): string;
}
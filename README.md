[![Latest Stable Version](https://poser.pugx.org/raigu/x-road-soap-envelope-builder/v/stable)](https://packagist.org/packages/raigu/x-road-soap-envelope-builder)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Build Status](https://travis-ci.com/raigu/x-road-soap-envelope-builder.svg?branch=master)](https://travis-ci.com/raigu/x-road-soap-envelope-builder)
[![codecov](https://codecov.io/gh/raigu/x-road-soap-envelope-builder/branch/master/graph/badge.svg)](https://codecov.io/gh/raigu/x-road-soap-envelope-builder)
[![Scrutinizer](https://scrutinizer-ci.com/g/raigu/x-road-soap-envelope-builder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/raigu/x-road-soap-envelope-builder/)

# x-road-soap-envelope

PHP library for creating a SOAP envelope for X-Road request.

Intended for applications which proxy several SOAP requests and must create SOAP requests dynamically. 
If you need to integrate only one X-Road service then this library might not be suitable.

# Requirements

* php 7.2+
* DOM extension

# Installation

```bash
$ composer require raigu/x-road-soap-envelope
``` 

# Usage

```php

require_once 'vendor/autoload.php';

use Raigu\XRoad\SoapEnvelope\SoapEnvelope;
use Raigu\XRoad\SoapEnvelope\Client;
use Raigu\XRoad\SoapEnvelope\ClientReference;
use Raigu\XRoad\SoapEnvelope\Service;
use Raigu\XRoad\SoapEnvelope\ServiceReference;
use Raigu\XRoad\SoapEnvelope\ServiceRequest;
use Raigu\XRoad\SoapEnvelope\UniqueId;

$envelope = new SoapEnvelope(
    new Client(
        new ClientReference('EE/GOV/MEMBER1/SUBSYSTEM1')
    ),
    new Service(
        new ServiceReference('EE/GOV/MEMBER2/SUBSYSTEM2/exampleService/v1')
    ),
    new ServiceRequest(
        '<ns1:exampleService xmlns:ns1="http://producer.x-road.eu">' .
        '<exampleInput>foo</exampleInput>' .
        '</ns1:exampleService>'
    ),
    new UniqueId
);


echo $envelope->asStr();
```

The above will output:

```text
<?xml version="1.0" encoding="UTF-8"?>
<env:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" xmlns:id="http://x-road.eu/xsd/identifiers"
              xmlns:xrd="http://x-road.eu/xsd/xroad.xsd">
    <env:Header>
        <xrd:client id:objectType="SUBSYSTEM">
            <id:xRoadInstance>EE</id:xRoadInstance>
            <id:memberClass>GOV</id:memberClass>
            <id:memberCode>MEMBER1</id:memberCode>
            <id:subsystemCode>SUBSYSTEM1</id:subsystemCode>
        </xrd:client>
        <xrd:service id:objectType="SERVICE">
            <id:xRoadInstance>EE</id:xRoadInstance>
            <id:memberClass>GOV</id:memberClass>
            <id:memberCode>MEMBER2</id:memberCode>
            <id:subsystemCode>SUBSYSTEM2</id:subsystemCode>
            <id:serviceCode>exampleService</id:serviceCode>
            <id:serviceVersion>v1</id:serviceVersion>
        </xrd:service>
        <xrd:id>0113072ef17ebb989e61a5b6c95f9efe</xrd:id>
        <xrd:protocolVersion>4.0</xrd:protocolVersion>
    </env:Header>
    <env:Body>
        <ns1:exampleService xmlns:ns1="http://producer.x-road.eu">
            <exampleInput>foo</exampleInput>
        </ns1:exampleService>
    </env:Body>
</env:Envelope>
```

The order of input parameters in `SoapEnvelope` constructor is not important.

There are more parameter types. See [Future test](tests/Feature/CreationOfXRoadRequestMessageTest.php), it demonstrates all options. 

# Motivation

This library has grown out from [raigu/x-road-soap-envelope-builder](https://github.com/raigu/x-road-soap-envelope-builder)
in pursuit of refining code metrics. The lesson I learned is that be suspicious about Maintainability Index.
"_size as a measure of maintainability has been underrated, and that the “sophisticated” maintenance metrics are overrated_"
[source](https://avandeursen.com/2014/08/29/think-twice-before-using-the-maintainability-index/).
 

# References

* [X-Road Terms and Abbreviations](https://www.x-tee.ee/docs/live/xroad/terms_x-road_docs.html)
* [X-Road: Message Protocol v4.0](https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#e1-request)
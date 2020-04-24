# x-road-soap-envelope-builder

PHP library for generating PSR-7 compatible X-Road SOAP envelope.

**UNDER CONSTRUCTION**

Useful for making X-Road requests using PSR-7 compatible libraries like [Guzzle](https://github.com/guzzle/guzzle).

Library exposes a builder for building X-Road SOAP envelope using X-Road Domain Language.
Built SOAP envelope is an instance implementing PSR-7 StreamInterface. 

# Usage

**Draft**

```php

$builder = SoapEnvelopeBuilder::create()
    ->withService('EE/COM/10256137/cre/test/v1')
    ->withClient('EE/COM/10256137/cre')
    ->withUserId('EE11111111111')
    ->withIssue('------')
    ->withXRoadMessageBody('______');

$envelope = $builder->build();

echo strval($envelope);
```

# Tutorial

How to make a X-Road client using raigu/x-road-soap-envelope.

```bash
$ mkdir example
$ cd example
$ composer init
$ composer require raigu/x-road-soap-envelope-builder
``` 


# References

* [X-Road Terms and Abbreviations](https://www.x-tee.ee/docs/live/xroad/terms_x-road_docs.html)
* [X-Road: Message Protocol v4.0](https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#e1-request)
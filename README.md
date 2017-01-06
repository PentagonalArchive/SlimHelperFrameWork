## Base Application Collection PSR7 - Slim 3

[![Build Status](https://travis-ci.org/pentagonal/SlimHelperFrameWork.svg?branch=master)](https://travis-ci.org/pentagonal/SlimHelperFrameWork)

This directory contains Bunch of applications

### Composer Dependency Required

**Common Required**

```json
{
    "php": ">=5.6",
    "aura/session": "^2.0",
    "doctrine/dbal": "^2.5",
    "guzzlehttp/guzzle": "~6.0",
    "monolog/monolog": "^1.22",
    "gettext/gettext": "^4.1",
    "slim/slim": "^3.5"
}
```

**Composer Optional For Slim FrameWork Override**


```json
{
  "slim/slim": "^3.5"
}
```

**Suggest Recommendation Password Hashing Library**

*note :*
    
    Just converted from openwall phpass

```json
{
    "pentagonal/phpass": "^1.0"
}
```

### NOTE

```
- Cache      : using `doctrine/cache`
- Database   : using `doctrine/dbal`
- Session    : using `aura/session`
- Translation: using `gettext/gettext`
- Logger     : using `monolog/monolog`
- Http Transport : using `guzzle/guzzle`
- Dependency injection : using `pimple/container`
- Request & Response   : using `psr/http-message`
```
### Installation

```bash

composer require pentagonal/slimhelper

```

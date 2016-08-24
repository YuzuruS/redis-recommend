Recommending API for Redis
=============================

[![Coverage Status](https://coveralls.io/repos/YuzuruS/redis-recommend/badge.png?branch=master)](https://coveralls.io/r/YuzuruS/redis-recommend)
[![Build Status](https://travis-ci.org/YuzuruS/redis-recommend.png?branch=master)](https://travis-ci.org/YuzuruS/redis-recommend)
[![Stable Version](https://poser.pugx.org/redis/recommend/v/stable.png)](https://packagist.org/packages/redis/recommend)
[![Download Count](https://poser.pugx.org/redis/ranking/downloads.png)](https://packagist.org/packages/redis/recommend)


Abstracting Redis's `Sorted Set` APIs to use as a recommending system.

Requirements
-----------------------------
- Redis
  - >=2.4
- PhpRedis extension
  - https://github.com/nicolasff/phpredis
- PHP
  - >=5.5 >=5.6, >=7.0
- Composer



Installation
----------------------------

* Using composer

```
{
    "require": {
       "redis/recommend": "1.0.*"
    }
}
```

```
$ php composer.phar update redis/recommend --dev
```


How to run unit test
----------------------------

Run with default setting.
```
% vendor/bin/phpunit -c phpunit.xml.dist
```

Currently tested with PHP 7.0.0 + Redis 2.6.12.


History
----------------------------
- 1.0.0
  - Published



License
----------------------------
MIT

Copyright
-----------------------------
- Yuzuru Suzuki
  - http://yuzurus.hatenablog.jp/

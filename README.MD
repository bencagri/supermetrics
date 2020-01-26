## SuperMetrics Fictional Rest API Manipulation

[![Travis CI](https://api.travis-ci.org/bencagri/supermetrics.svg?branch=master)](https://travis-ci.org/bencagri/supermetrics)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bencagri/supermetrics/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bencagri/supermetrics/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/bencagri/supermetrics/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
#### Approach to assignment
I choosed Domain Driven Design with TDD approach for extendable simple service. Meantime due to its Framework agnostic model, 
the entire code could be implemented in any modern framework, ie laravel, symfony, yii etc. 

#### Standards

* PSR-2 coding style
* PSR-4 autoloading
* PSR-7 HTTP Messages - [League/Route](https://route.thephpleague.com/4.x/) with [Guzzle/Psr7](https://github.com/guzzle/psr7)
* PSR-11 Container Interface - [League/Container](https://container.thephpleague.com/3.x/)
* PSR-15 Request Handler [laminas/laminas-httphandlerrunner](https://github.com/laminas/laminas-httphandlerrunner)

### Usage

#### Endpoints

|  Resource | Method | Endpoint |
|-----------|--------|----------|
|  All      | GET    | /stats   | 
|  Average Character Length of Post | GET | /stats/averageCharacterLengthOfPost | 
|  Average Posts by User per Month | GET | /stats/averagePostByUserPerMonth | 
|  Maximum Post Length by Month | GET | /stats/maximumPostLengthByMonth | 
|  Total Post Length Per Week | GET | /stats/totalPostsPerWeek | 

### Installation

You can run script via Docker or Standalone.

#### 1. With Docker
```bash
docker-compose up
```
then point your browser to `127.0.0.1:8082`

#### 2. Standalone
you need `composer`
```php
composer install
cp .env.dist .env
php -S 127.0.0.1:8082 -t public
```

then point your browser to `127.0.0.1:8082`

### Tests
to run phpunit tests
```bash
vendor/bin/phpunit
```
or via docker
```
docker exec -it supermetrics "vendor/bin/phpunit"
```
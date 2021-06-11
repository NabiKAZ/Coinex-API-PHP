# Coinex API PHP
Coinex digital coin exchange API for PHP

## Requirements
- PHP>=5.4
- CURL PHP module

## Install
```
composer require NabiKAZ\CoinexAPI
```

## Acquire access\_id and secret\_key
Sign in to [CoinEx](https://www.coinex.com) before invoking API and get Acquire access\_id/secret\_key in **Account** &gt; **API**.

> access\_id: To mark identity of API invoker
> 
> secret\_key: Key to sign the request parameters

## Setup request
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use NabiKAZ\Coinex\CoinexAPI;

//use this variable in some functions as global
$access_id = '<ACCESS_ID>';
$secret_key = '<SECRET_KEY';

//create api object
$coinex = new CoinexAPI($access_id, $secret_key);
```

## Set params
```php
//params if nedded
//IMPORTANT: no needed set access_id, tonce into params.
$params = [
];
```

## Arguments of request
|    name   |  type  | required | default |          example          | description            |
|:---------:|:------:|:--------:|:-------:|:-------------------------:|------------------------|
| `$url`    | string | yes      | -       | `'market/ticker'`         | The request URL        |
| `$params` | array  | no       | `[]`    | `['market'=>'BCHBTC']`    | The request parameters |
| `$method` | string | no       | `'get'` | `'get', 'post', 'delete'` | The request method     |

## Send request (Method 1)
```php
//send request
$coinex->url = $url;
$coinex->params = $params;
$coinex->method = $method;
$res = $coinex->send();
```

## Send request (Method 2)
```php
//send request
$res = $coinex->send($url, $params, $method);
```

## See results
```PHP
//see results
var_dump($res);
```

## Examples
You can see more examples in the `examples.php` file.

## Wiki
See all requests, params and responses in [here official wiki](https://github.com/coinexcom/coinex_exchange_api/wiki).

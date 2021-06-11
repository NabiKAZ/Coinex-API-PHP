<?php
/**
 * Coinex digital coin exchange API for PHP
 *
 * @author Nabi KAZ <nabi@gmail.com> <www.nabi.ir>
 * @package https://github.com/NabiKAZ/Coinex-API-PHP
 * @license GPL-3.0-or-later
 */

require __DIR__ . '/../../vendor/autoload.php';

use NabiKAZ\Coinex\CoinexAPI;

//use this variable in some functions as global
$access_id = '<ACCESS_ID>';
$secret_key = '<SECRET_KEY>';

//create api object
$coinex = new CoinexAPI($access_id, $secret_key);

//Acquire Currency Rate: https://github.com/coinexcom/coinex_exchange_api/wiki/070currency_rate
$res = $coinex->send('common/currency/rate');
var_dump($res);

//Acquire Market List: https://github.com/coinexcom/coinex_exchange_api/wiki/020market
$res = $coinex->send('market/list');
var_dump($res);

//Inquire Account Info: https://github.com/coinexcom/coinex_exchange_api/wiki/060balance
$res = $coinex->send('balance/info');
var_dump($res);

//Inquire Withdrawal List: https://github.com/coinexcom/coinex_exchange_api/wiki/061get_withdraw_list
$res = $coinex->send('balance/coin/withdraw', ['coin_type' => 'BTC'], 'get');
var_dump($res);

//Submit Withdrawal Order: https://github.com/coinexcom/coinex_exchange_api/wiki/062submit_withdraw
$coinex->url = 'balance/coin/withdraw';
$coinex->params = [
    'coin_type' => 'BTC',
    'coin_address' => 'xyz',
    'transfer_method' => 'onchain',
    'actual_amount' => '1.00000000',
];
$coinex->method = 'post';
$res = $coinex->send();
var_dump($res);

//Cancel Withdrawal: https://github.com/coinexcom/coinex_exchange_api/wiki/064cancel_withdraw
$res = $coinex->send('balance/coin/withdraw', ['coin_withdraw_id' => 100], 'delete');
var_dump($res);

//SEE FOR MORE: https://github.com/coinexcom/coinex_exchange_api/wiki

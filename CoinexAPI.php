<?php
/**
 * Coinex digital coin exchange API for PHP
 *
 * @author Nabi KAZ <nabikaz@gmail.com> <www.nabi.ir>
 * @package https://github.com/NabiKAZ/Coinex-API-PHP
 * @license GPL-3.0-or-later
 */

namespace NabiKAZ\Coinex;

class CoinexAPI
{
    public $access_id;
    public $secret_key;
    public $url;
    public $params = [];
    public $method = 'GET';

    public function __construct($access_id, $secret_key)
    {
        $this->access_id = $access_id;
        $this->secret_key = $secret_key;
    }

    public function send($url = '', $params = '', $method = '')
    {

        if (!$url) {
            $url = $this->url;
        }

        if (!$params) {
            $params = $this->params;
        }

        if (!$method) {
            $method = $this->method;
        }

        if (!$url) {
            echo 'ERROR: The URL required.' . PHP_EOL;
            return false;
        }

        //check CURL extension
        if (!extension_loaded('curl')) {
            echo 'ERROR: The CURL module is not enabled for PHP.' . PHP_EOL;
            return false;
        }

        //set base url
        $base_url = 'https://api.coinex.com/v1/';

        //normalize url
        $url = trim(strtolower($url));
        if (strpos($url, '/') === 0) $url = substr($url, 1);
        if (strpos($url, 'https://') !== 0 && strpos($url, 'http://') !== 0) $url = $base_url . $url;

        //preparation request
        $ch = curl_init();

        //add tonce to params
        $params = array_merge($params, ['tonce' => time() * 1000]);
        $params = array_merge($params, ['access_id' => $this->access_id]);

        //set method request
        $method = strtoupper($method);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        //set params for POST or GET request
        if ($method == 'GET') {
            $url .= '?' . http_build_query($params);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }

        //for debug
        //curl_setopt($ch, CURLOPT_VERBOSE, true);

        //sign params
        ksort($params);
        $params = array_merge($params, ['secret_key' => $this->secret_key]);
        $sign = http_build_query($params);
        $sign = md5($sign);
        $sign = strtoupper($sign);

        //set url
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //set header request
        $headers = [];
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: ' . $sign;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //send request
        $result = curl_exec($ch);

        //error handling request
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch) . PHP_EOL;
            return false;
        }

        //close request
        curl_close($ch);

        //return json result
        return json_decode($result, true);
    }

}
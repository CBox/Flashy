<?php

require_once 'Flashy/Sms.php';
require_once 'Flashy/Exceptions.php';

class Flashy {
    
    public $apikey;
    public $ch;
    public $root = 'https://flashyapp.com/api/';
    public $debug = false;

    public static $error_map = array(
        "Invalid_Key" => "Flashy_Invalid_Key",
    );

    public function __construct($apikey=null) {
        if(!$apikey) $apikey = getenv('FLASHY_APIKEY');

        if(!$apikey) throw new Flashy_Error('You must provide a Flashy API key');

        $this->apikey = $apikey;

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Flashy-PHP/1.0.54');
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 600);

        $this->root = rtrim($this->root, '/') . '/';

        $this->sms = new Flashy_Sms($this);
    }

    public function __destruct() {
        curl_close($this->ch);
    }

    public function call($url, $params) {
        $params['key'] = $this->apikey;

        $params = json_encode($params);

        $ch = $this->ch;

        curl_setopt($ch, CURLOPT_URL, $this->root . $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);

        $start = microtime(true);

        $this->log('Call to ' . $this->root . $url . ' ' . $params);

        $response_body = curl_exec($ch);
        $info = curl_getinfo($ch);

        $time = microtime(true) - $start;

        $this->log('Completed in ' . number_format($time * 1000, 2) . 'ms');
        $this->log('Got response: ' . $response_body);

        if(curl_error($ch)) {
            throw new Flashy_HttpError("API call to $url failed: " . curl_error($ch));
        }

        $result = json_decode($response_body, true);

        if($result === null) throw new Flashy_Error('We were unable to decode the JSON response from the Flashy API: ' . $response_body);
        
        if(floor($info['http_code'] / 100) >= 4) {
            throw $this->castError($result);
        }

        return $result;
    }

    public function castError($result) {
        if($result['status'] !== 'error' || !$result['name']) throw new Flashy_Error('We received an unexpected error: ' . json_encode($result));

        $class = (isset(self::$error_map[$result['name']])) ? self::$error_map[$result['name']] : 'Flashy_Error';
        return new $class($result['message'], $result['code']);
    }

    public function log($msg) {
        if($this->debug) error_log($msg);
    }
}
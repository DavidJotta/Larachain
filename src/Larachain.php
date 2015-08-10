<?php namespace DavidJotta\Larachain;

/**
 * Larachain for Laravel 5.1!
 *
 * @package Larachain
 * @version 0.1
 * @author DavidJotta <DavidJotta143@gmail.com>
 * @license The UNLICENSE
 * @website https://github.com/DavidJotta
 *
 * Have fun tinkering around!
 */

use DavidJotta\Larachain\Rates\Rates;
use Illuminate\Config\Repository;

class Larachain {

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var Channel
     */
    protected $channel;

    /**
     * Class-referenced variables
     *
     * @var Rates reference
     * @var Gateways reference
     */
    protected $Rates;
    protected $Gateways;

    /**
     * Constructor
     *
     * @param Repository $config
     */
    public function __construct(Repository $config) {
        $this->config = array(
            'api_url' => config('api_url'),
            'api_code' => config('api_code'),
            'default_wallet' => config('default_wallet'),
            'callback_url' => config('callback_url')
        );
        $this->channel = curl_init();
        curl_setopt($this->channel, CURLOPT_USERAGENT, 'Larachain/0.1');
        curl_setopt($this->channel, CURLOPT_HEADER, false);
        curl_setopt($this->channel, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->channel, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->channel, CURLOPT_TIMEOUT, 60);
        curl_setopt($this->channel, CURLOPT_CAINFO, dirname(__FILE__).'/Blockchain/ca-bundle.crt');
        $this->Rates = new Rates($this);
        $this->Gateways = new Gateways($this);
    }

    /**
     * Destructor
     */
    public function __destruct() {
        curl_close($this->channel);
    }

    /**
     * Shortcut to toBTC() sub-class method
     *
     * @param $amount
     * @param $currency
     *
     * @return mixed
     */
    public function toBTC($amount, $currency) {
        return $this->Rates->toBTC($amount, $currency);
    }

    /**
     * Shortcut to createGateway() sub-class method
     *
     * @param $address
     * @param $callback
     *
     * @return mixed
     */
    public function createGateway($address = null, $callback = null) {
        if(!isset($address)) $address = $this->config['default_address'];
        if(!isset($callback)) $callback = $this->config['callback_url'];
        return $this->Gateways->createGateway($address, $callback);
    }

    /**
     * GET the Blockchain API
     *
     * @param string $resource
     * @param array $params
     *
     * @return mixed
     */
    public function getAPI($resource, $params = null) {
        curl_setopt($this->channel, CURLOPT_POST, false);
        (!empty($this->config['api_code'])) ? $params['api_code'] = $this->config['api_code'] : '';
        curl_setopt($this->channel, CURLOPT_HTTPHEADER, array());
        $query = http_build_query($params);
        curl_setopt($this->channel, CURLOPT_URL, $this->config['api_url'].$resource.'?'.$query);
        return $this->_call();
    }

    /**
     * POST the Blockchain API
     *
     * @param string $resource
     * @param array $data
     *
     * @return mixed
     */
    public function postAPI($resource, $data = null) {
        curl_setopt($this->channel, CURLOPT_POST, true);
        curl_setopt($this->channel, CURLOPT_URL, $this->config['api_url'].$resource);
        curl_setopt($this->channel, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
        (!empty($this->config['api_code'])) ? $params['api_code'] = $this->config['api_code'] : '';
        curl_setopt($this->channel, CURLOPT_POSTFIELDS, http_build_query($data));
        $json = $this->_call();
        return $json;
    }

    /**
     * Call the Blockchain API
     *
     * @return mixed
     */
    private function _call() {
        $response = curl_exec($this->channel);
        $json = json_decode($response, true);
        return $json;
    }
}
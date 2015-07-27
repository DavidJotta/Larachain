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
     * @var API URL
     */
    protected $apiURL;

    /**
     * Class-referenced variables
     *
     * @var Rates reference
     */
    protected $Rates;

    /**
     * Constructor
     *
     * @param Repository $config
     */
    public function __construct(Repository $config) {
        $this->config = $config;
        $this->channel = curl_init();
        $this->apiURL = $config['api_url'];
        curl_setopt($this->channel, CURLOPT_USERAGENT, 'Larachain/0.1');
        curl_setopt($this->channel, CURLOPT_HEADER, false);
        curl_setopt($this->channel, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->channel, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->channel, CURLOPT_TIMEOUT, 60);
        curl_setopt($this->channel, CURLOPT_CAINFO, dirname(__FILE__).'/Blockchain/ca-bundle.crt');
        $this->Rates = new Rates($this);
    }

    /**
     * Destructor
     */
    public function __destruct() {
        curl_close($this->channel);
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
        $params['api_code'] = $this->config['api_code'];
        curl_setopt($this->channel, CURLOPT_HTTPHEADER, array());
        $query = http_build_query($params);
        curl_setopt($this->channel, CURLOPT_URL, $this->apiURL.$resource.'?'.$query);
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
        curl_setopt($this->channel, CURLOPT_URL, $this->apiURL.$resource);
        curl_setopt($this->channel, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
        $data['api_code'] = $this->config['api_code'];
        curl_setopt($this->channel, CURLOPT_POSTFIELDS, http_build_query($data));
        return $this->_call();
    }

    /**
     * Call the Blockchain API
     *
     * @return mixed
     */
    private function _call() {
        $response = curl_exec($this->channel);
        return json_decode($response, true);
    }
}
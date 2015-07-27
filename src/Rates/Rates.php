<?php namespace DavidJotta\Larachain\Rates;

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

use DavidJotta\Larachain\Larachain;

class Rates {

    /**
     * @var Larachain reference
     */
    protected $larachain;

    /**
     * Constructor
     *
     * @param Larachain $larachain
     */
    public function __construct(Larachain $larachain) {
        $this->larachain = $larachain;
    }

    /**
     * Get Rates from Blockchain API
     *
     * @return array
     */
    public function get() {
        $rates = array();
        $json = $this->larachain->getAPI('ticker', array('format' => 'json'));
        foreach($json as $cur => $data) {
            $rates[$cur] = new Ticker($cur, $data);
        }
        return $rates;
    }

    /**
     * Convert $amount to Bitcoins
     *
     * @param $amount
     * @param $symbol
     *
     * @return mixed
     */
    public function toBTC($amount, $symbol) {
        $params = array(
            'currency' => $symbol,
            'value' => $amount,
            'format' => 'json'
        );
        return $this->larachain->getAPI('tobtc', $params);
    }
}
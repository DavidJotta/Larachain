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

class Ticker {

    /**
     * Properties
     *
     * @var float $m15
     * @var float $last
     * @var float $buy
     * @var float $sell
     * @var string $cur
     * @var string $symbol
     */
    public $m15;
    public $last;
    public $buy;
    public $sell;
    public $cur;
    public $symbol;

    /**
     * Constructor
     *
     * @param $cur
     * @param $json
     */
    public function __construct($cur, $json) {
        $this->cur = $cur;
        if(array_key_exists('15m', $json)) $this->m15 = $json['15m'];
        if(array_key_exists('last', $json)) $this->last = $json['last'];
        if(array_key_exists('buy', $json)) $this->buy = $json['buy'];
        if(array_key_exists('sell', $json)) $this->sell = $json['sell'];
        if(array_key_exists('symbol', $json)) $this->symbol = $json['symbol'];
    }
}
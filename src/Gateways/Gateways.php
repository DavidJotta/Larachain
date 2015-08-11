<?php namespace DavidJotta\Larachain\Gateways;

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

class Gateways {

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
     * Create a gateway wallet
     *
     * @param $address
     * @param $callback
     *
     * @return mixed
     */
    public function createGateway($address, $callback) {
        $params = array(
            'method' => 'create',
            'cors' => 'true',
            'format' => 'json',
            'address' => $address,
            'shared' => 'false',
            'callback' => urldecode(urlencode($callback))
        );
        return $this->larachain->getAPI('api/receive', $params);
    }
}
<?php namespace DavidJotta\Larachain\Facades;

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

use Illuminate\Support\Facades\Facade;

/**
 * @see \DavidJotta\Larachain
 */
class Larachain extends Facade {

    protected static function getFacadeAccessor() { return 'larachain'; }
}
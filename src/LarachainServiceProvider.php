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

use Illuminate\Support\ServiceProvider;

class LarachainServiceProvider extends ServiceProvider {

    /**
     * Boot Larachain service provider.
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            __DIR__ . '/../config/larachain.php' => config_path('larachain.php')
        ], 'config');
    }

    /**
     * Register Larachain service provider.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(__DIR__.'/../config/larachain.php', 'larachain');
        $this->app->bind('larachain', function($app) {
            return new Larachain(
                $app['Illuminate\Config\Repository']
            );
        });
    }
}
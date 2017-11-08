<?php
/**
 * Created by PhpStorm.
 * User: sune
 * Date: 08/11/2017
 * Time: 15.41
 */

namespace Westphalen\Laravel\Change\Providers;

class LaravelServiceProvider extends LumenServiceProvider
{
    /**
     * Boot the routes for the package.
     */
    public function boot()
    {
        parent::boot();

        // Load laravel routes.
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }
}

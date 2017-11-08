<?php
/**
 * Created by PhpStorm.
 * User: sune
 * Date: 08/11/2017
 * Time: 15.42
 */

namespace Westphalen\Laravel\Change\Providers;

use Illuminate\Support\ServiceProvider;

class LumenServiceProvider extends ServiceProvider
{
    /**
     * Load migrations for the package.
     */
    public function boot()
    {
        // Load migration.
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}

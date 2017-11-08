<?php
/**
 * Created by PhpStorm.
 * User: sune
 * Date: 08/11/2017
 * Time: 15.15
 */

Route::get('change/{id}', \Westphalen\Laravel\Change\Controllers\ChangeController::class . '@apply');

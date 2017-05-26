<?php
/**
 * Created by PhpStorm.
 * User: LONGYONGYU
 * Date: 2017/5/25
 * Time: 14:56
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Auth\CustomAuth;
class CustomAuthServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('customauth', function ($app) {
            return new CustomAuth();
        });
    }

}
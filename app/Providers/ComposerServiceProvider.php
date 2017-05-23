<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/13
 * Time: 22:00
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(){
        view()->composer('admin.*', 'App\Http\ViewComposers\GlobalComposer');
    }

    public function register()
    {
        // ttest git reset
    }
}
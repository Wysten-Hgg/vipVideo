<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

            View()->composer('common.navbar',function ($view){
                $result = DB::table('watchtimes')->where([
                    ['uid', '=', session('uid')],
                    ['end_time', '<>', 0],
                ])->select(DB::raw('sum(end_time)-sum(start_time) as sumtimes'))->first();

                $sec = round($result->sumtimes/60);
                if ($sec >= 60){
                    $hour = floor($result->sumtimes/60);
                    $min = $sec%60;
                    $res = $hour.' 小时 ';
                    $min != 0  &&  $res .= $min.' 分';
                }else{
                    $res = $sec.' 分钟';
                }
                $view->with('sumtimes', $res);

            });
            
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

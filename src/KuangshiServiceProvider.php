<?php

namespace Finalsmile6868\Kuangshi;

use Illuminate\Support\ServiceProvider;

use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class KuangshiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       
        $this->loadMigrationsFrom(__DIR__.'/../migrations'); 
        $source = __DIR__.'/../config/kuangshi.php';

        if ($this->app instanceof LaravelApplication) {
             $this->loadRoutesFrom(__DIR__.'/../routes.php');
            if($this->app->runningInConsole()){
                $this->publishes([
                    // __DIR__.'/../resources/views'=>base_path('resources/views/vendor/kuangshi'), // 发布视图目录到resources下
                    $source =>config_path('kuangshi.php'),//发布配置文件到config目录
                ]);
            }
            $this->loadViewsFrom(__DIR__.'/../resources/views','kuangshi');//指定视图目录         
        }elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('kuangshi');
        }       
               
        $this->mergeConfigFrom($source, 'kuangshi');
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('kuangshi',function($app){
            return new Kuangshi();
        });
    }

    public function provides(){
        return ['Finalsmile6868\\Kuangshi\\Kuangshi'];
    }
}

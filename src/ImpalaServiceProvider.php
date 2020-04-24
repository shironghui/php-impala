<?php

namespace Odbc\Impala;

use Illuminate\Support\ServiceProvider;

class ImpalaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/impala.php' => config_path('impala.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('impala', function ($app) {
            return new Impala($app['session'], $app['config']);
        });
    }

    public function provides()
    {
        // ��Ϊ�ӳټ��� ����Ҫ���� provides ����
        return ['impala'];
    }
}

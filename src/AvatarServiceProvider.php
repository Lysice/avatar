<?php
/**
 * Created by PhpStorm.
 * User: zhao
 * Date: 19-9-6
 * Time: 下午6:30
 */
namespace Lysice\Avatar;

use Illuminate\Support\ServiceProvider;

class AvatarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__ . '/config/avatar.php' => config_path('avatar.php'),
            __DIR__ . '/fonts/hwxk.ttf' => public_path('fonts/font.ttf')
        ]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('avatar', function ($app) {
            return new Avatar($app['config']);
        });
    }
}
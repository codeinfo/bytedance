<?php

namespace Codeinfo\Bytedance;

use Codeinfo\Bytedance\Contracts\BaseInterface;
use Codeinfo\Bytedance\Contracts\WeappInterface;
use Illuminate\Contracts\Support\DeferrableProvider as LaravelDeferrableProvider;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider implements LaravelDeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerPlatform();

        $this->registerWeapp();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/bytedance.php' => config_path('bytedance.php'),
        ], 'config');
    }

    public function provides(): array
    {
        return [
            BaseInterface::class => 'bytedance.platform',
            WeappInterface::class => 'bytedance.weapp',
        ];
    }

    public function registerPlatform(): void
    {
        $this->app->bind(BaseInterface::class, function ($app) {
            return new BaseService($app['config']['bytedance']['platform']);
        });

        $this->app->alias(BaseInterface::class, 'bytedance.platform');
    }

    protected function registerWeapp(): void
    {
        $this->app->bind(WeappInterface::class, function ($app) {
            return new WeappService($app['config']['byte']['weapp']);
        });

        $this->app->alias(WeappInterface::class, 'bytedance.weapp');
    }
}

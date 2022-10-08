<?php

namespace Codeinfo\LaravelBytedance\Platform\Data;

use Codeinfo\LaravelBytedance\Kernel\Contracts\ServiceProviderInterface;
use Illuminate\Container\Container;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['data'] = function ($app) {
            return new Data($app);
        };
    }
}

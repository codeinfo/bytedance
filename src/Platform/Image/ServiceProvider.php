<?php

namespace Codeinfo\LaravelBytedance\Platform\Image;

use Codeinfo\LaravelBytedance\Kernel\Contracts\ServiceProviderInterface;
use Illuminate\Container\Container;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['image'] = function ($app) {
            return new Image($app);
        };
    }
}

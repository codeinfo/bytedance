<?php

namespace Codeinfo\LaravelBytedance\Platform\Hudong;

use Codeinfo\LaravelBytedance\Kernel\Contracts\ServiceProviderInterface;
use Illuminate\Container\Container;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['hudong'] = function ($app) {
            return new Hudong($app);
        };
    }
}

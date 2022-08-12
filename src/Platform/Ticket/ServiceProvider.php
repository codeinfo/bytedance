<?php

namespace Codeinfo\LaravelBytedance\Platform\Ticket;

use Codeinfo\LaravelBytedance\Kernel\Contracts\ServiceProviderInterface;
use Illuminate\Container\Container;

class ServiceProvider  implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['ticket'] = function ($app) {
            return new Ticket($app);
        };
    }
}

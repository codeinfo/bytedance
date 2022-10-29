<?php
namespace Codeinfo\LaravelBytedance\Platform\Life;

use Codeinfo\LaravelBytedance\Kernel\Contracts\ServiceProviderInterface;
use Codeinfo\LaravelBytedance\Platform\Life\Life;
use Illuminate\Container\Container;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['life'] = function ($app) {
            return new Life($app);
        };
    }
}

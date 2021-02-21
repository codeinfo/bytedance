<?php

/**
 * This file is part of the Codeinfo\LaravelBytedance.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Codeinfo\LaravelBytedance\Platform\Oauth;

use Codeinfo\LaravelBytedance\Kernel\Contracts\ServiceProviderInterface;
use Illuminate\Container\Container;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['oauth'] = function ($app) {
            return new Oauth($app);
        };
    }
}

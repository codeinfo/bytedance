<?php

/**
 * This file is part of the Codeinfo\LaravelBytedance.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Codeinfo\LaravelBytedance\Platform;

use Codeinfo\LaravelBytedance\Kernel\ServiceContainer;

class Application extends ServiceContainer
{
    protected $providers = [
        Oauth\ServiceProvider::class,
        Account\ServiceProvider::class,
        Video\ServiceProvider::class,
        Image\ServiceProvider::class,
        Ticket\ServiceProvider::class,
        Data\ServiceProvider::class,
        Life\ServiceProvider::class,
    ];

    /**
     * Handle dynamic calls.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->base->$method(...$args);
    }
}

<?php

/**
 * This file is part of the codeinfo/ByteDanceLaravel.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ByteDanceLaravel\Kernel;

use Illuminate\Container\Container;

class ServiceContainer extends Container
{
    public function __construct($config)
    {
        $this['config'] = function () use ($config) {
            return $config;
        };

        //register the provider
        foreach ($this->providers as $provider) {
            $provider = new $provider();
            $provider->register($this);
        }
    }
}

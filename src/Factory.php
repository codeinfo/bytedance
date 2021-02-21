<?php

/**
 * This file is part of the Codeinfo\LaravelBytedance.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Codeinfo\LaravelBytedance;

use Illuminate\Support\Str;

/**
 * Class Factory.
 *
 * @method static Codeinfo\LaravelBytedance\Platform\Application            platform(array $config)
 */
class Factory
{
    /**
     * @param string $name
     * @param array  $config
     *
     * @return Codeinfo\LaravelBytedance\Kernel\ServiceContainer
     */
    public static function make($name, array $config)
    {
        $namespace = Str::studly($name);
        $application = "\\Codeinfo\\LaravelBytedance\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}

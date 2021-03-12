<?php

/*
 * This file is part of the stingbo/easyipfs.
 *
 * (c) sting bo <sting_bo@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyIPFS;

use EasyIPFS\Kernel\ServiceContainer;

/**
 * Class Factory.
 *
 * @method static \EasyIPFS\Application ipfs(array $config)
 */
class Factory
{
    public static function make(string $name, array $config): ServiceContainer
    {
        return new Application($config);
//        $namespace = Kernel\Support\Str::studly($name);
//        $application = "\\EasyIPFS\\{$namespace}\\Application";

//        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments): ServiceContainer
    {
        return self::make($name, ...$arguments);
    }
}

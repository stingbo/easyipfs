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

/**
 * Class Factory.
 *
 * @method static \EasyIPFS\Application ipfs(array $config)
 */
class Factory
{
    /**
     * @return mixed
     */
    public static function make(string $name, array $config)
    {
        $app = new Application($config);

        return $app->{$name};
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return self::make($name, ...$arguments);
    }
}

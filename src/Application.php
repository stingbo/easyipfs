<?php

namespace EasyIPFS;

use EasyIPFS\Kernel\ServiceContainer;

/**
 * Class Application.
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Basic\ServiceProvider::class,
    ];
}

<?php

namespace EasyIPFS\Tests;

use EasyIPFS\Factory;

class FactoryTest extends TestCase
{
    public function testStaticCall()
    {
        $config = [
            'response_type' => 'array',
            'base_uri' => 'http://127.0.0.1',
        ];
        $this->assertInstanceOf(
            \EasyIPFS\Basic\Client::class,
            Factory::basic($config)
        );
    }
}

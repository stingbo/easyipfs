<?php

namespace EasyIPFS\Tests\Basic;

use EasyIPFS\Basic\Client;
use EasyIPFS\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testId()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpPost('/api/v0/id', [])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->id([]));
    }
}

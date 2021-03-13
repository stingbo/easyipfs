<?php

namespace EasyIPFS\Basic;

use EasyIPFS\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Show ipfs node id info.
     *
     * @param $get_params
     *
     * @return array|\EasyIPFS\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function id($get_params = [])
    {
        return $this->httpPost('/api/v0/id', $get_params);
    }
}

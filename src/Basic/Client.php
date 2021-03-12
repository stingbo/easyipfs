<?php

namespace EasyIPFS\Basic;

use EasyIPFS\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * @return array|\EasyIPFS\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     */
    public function id($params)
    {
        return $this->httpPost('/api/v0/id', $params);
    }
}

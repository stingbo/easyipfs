<?php

namespace EasyIPFS\Basic;

use EasyIPFS\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Show ipfs node id info.
     *
     * @param array $query
     *
     * @return array|\EasyIPFS\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function id($query = [])
    {
        return $this->httpPost('/api/%s/id', $query);
    }

    /**
     * Download IPFS objects.
     *
     * @param array $query
     *
     * @return string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($query = [])
    {
        return $this->requestRaw('/api/%s/get', 'POST', ['query' => $query])->getBodyContents();
    }

    /**
     * Add a file to ipfs.
     *
     * @param array $files
     * @param array $query
     *
     * @return array|\EasyIPFS\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add(array $files, $query = [])
    {
        return $this->httpUpload('/api/%s/add', $files, $query);
    }

    /**
     * Show IPFS object data.
     *
     * @param array $query
     *
     * @return array|\EasyIPFS\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cat($query = [])
    {
        return $this->requestRaw('/api/%s/cat', 'POST', ['query' => $query])->getBodyContents();
    }
}

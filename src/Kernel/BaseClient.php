<?php

namespace EasyIPFS\Kernel;

use EasyIPFS\Kernel\Http\Response;
use EasyIPFS\Kernel\Traits\HasHttpRequests;
use Psr\Http\Message\RequestInterface;

class BaseClient
{
    use HasHttpRequests {
        request as performRequest;
    }

    /**
     * @var \EasyIPFS\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $version = 'v0';

    /**
     * BaseClient constructor.
     *
     * @param \EasyIPFS\Kernel\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
        $this->version = $app->config->get('version') ?? 'v0';
    }

    /**
     * @param bool $returnRaw
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyIPFS\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $url, string $method = 'GET', array $options = [], $returnRaw = false)
    {
        if (empty($this->middlewares)) {
            $this->registerHttpMiddlewares();
        }

        $response = $this->performRequest($url, $method, $options);

        return $returnRaw ? $response : $this->castResponseToType($response, $this->app->config->get('response_type'));
    }

    /**
     * GET request.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyIPFS\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpGet(string $url, array $query = [], string $sign_type = 'NONE')
    {
        $this->sign_type = $sign_type;

        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * POST request.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyIPFS\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPost(string $url, array $query = [], array $data = [])
    {
        $url = sprintf($url, $this->version);

        return $this->request($url, 'POST', ['form_params' => $data, 'query' => $query], true);
    }

    /**
     * JSON request.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyIPFS\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyIPFS\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPostJson(string $url, array $data = [], array $query = [])
    {
        return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $options
     *
     * @return Response
     *
     * @throws Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestRaw(string $url, string $method = 'GET', array $options = [])
    {
        $url = sprintf($url, $this->version);

        return Response::buildFromPsrResponse($this->request($url, $method, $options, true));
    }

    /**
     * DELETE request.
     *
     * @return array|Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpDelete(string $url, array $query = [])
    {
        return $this->request($url, 'DELETE', ['query' => $query]);
    }

    /**
     * Upload file.
     *
     * @param string $url
     * @param array $files
     * @param array $form
     * @param array $query
     *
     * @return array|Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpUpload(string $url, array $files = [], array $form = [], array $query = [])
    {
        $multipart = [];
        $headers = [];
        $url = sprintf($url, $this->version);

        if (isset($form['filename'])) {
            $headers = [
                'Content-Disposition' => 'form-data; name="file"; filename="'.$form['filename'].'"'
            ];
        }

        foreach ($files as $name => $path) {
            $multipart[] = [
                'name' => $name,
                'contents' => fopen($path, 'r'),
                'headers' => $headers
            ];
        }

        foreach ($form as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }

        return $this->request(
            $url,
            'POST',
            ['query' => $query, 'multipart' => $multipart, 'connect_timeout' => 30, 'timeout' => 30, 'read_timeout' => 30]
        );
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
    }

    /**
     * 增加header.
     *
     * @param $header
     * @param $value
     *
     * @return \Closure
     */
    protected function addHeaderMiddleware($header, $value)
    {
        return function (callable $handler) use ($header, $value) {
            return function (RequestInterface $request, array $options) use ($handler, $header, $value) {
                $request = $request->withHeader($header, $value);

                return $handler($request, $options);
            };
        };
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Jmiy
 * Date: 2021-09-27
 * Time: 11:02 update
 */

namespace DingNotice;

use DingNotice\Contracts\HttpClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class HttpClient implements HttpClientInterface
{
    protected $client;
    protected $config;
    /**
     * @var string
     */
    protected $hookUrl = "https://oapi.dingtalk.com/robot/send";

    /**
     * @var string
     */
    protected $accessToken = "";

    public function __construct($config)
    {
        $this->config = $config;
        $this->setAccessToken();
        $this->client = $this->createClient();
    }

    /**
     *
     */
    public function setAccessToken(){
        $this->accessToken = $this->config['token'];
    }

    /**
     * create a guzzle client
     * @return Client
     * @author wangju 2019-05-17 20:25
     */
    protected function createClient()
    {
        $client = new Client([
            'timeout' => $this->config['timeout'] ?? 2.0,
        ]);
        return $client;
    }

    /**
     * @return string
     */
    public function getRobotUrl()
    {
        $query['access_token'] = $this->accessToken;
        if (isset($this->config['secret']) && $secret = $this->config['secret']) {
            $timestamp = time() . sprintf('%03d', rand(1, 999));
            $sign      = hash_hmac('sha256', $timestamp . "\n" . $secret, $secret, true);
            $query['timestamp'] = $timestamp;
            $query['sign'] = base64_encode($sign);
        }
        return $this->hookUrl . "?" . http_build_query($query);
    }

    /**
     * send message
     * @param $url
     * @param $params
     * @return array
     * @author Jmiy 2021-09-27 11:15 update
     */
    public function send($params): array
    {
        $response = $this->client->post($this->getRobotUrl(), [
//            'body' => json_encode($params),
//            'headers' => [
//                'Content-Type' => 'application/json',
//            ],
//            'verify' => $this->config['ssl_verify'] ?? true,

//            RequestOptions::BODY => json_encode($params),
//            RequestOptions::HEADERS => [
//                'Content-Type' => 'application/json',
//            ],
//            RequestOptions::VERIFY => $this->config['ssl_verify'] ?? true,

//            RequestOptions::BODY => json_encode($params),
//            RequestOptions::HEADERS => [
//                'Content-Type' => 'application/json',
//            ],
//            RequestOptions::VERIFY => $this->config['ssl_verify'] ?? true,

            RequestOptions::JSON => $params,
            RequestOptions::VERIFY => $this->config['ssl_verify'] ?? true,
        ]);

        $result = $response->getBody()->getContents();

        return json_decode($result, true) ?? [];
    }
}

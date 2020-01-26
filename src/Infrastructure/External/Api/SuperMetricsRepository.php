<?php

namespace SuperMetrics\Infrastructure\External\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use SuperMetrics\Application\Client\Credentials;
use SuperMetrics\Application\Shared\Logger;
use SuperMetrics\Domain\Post;
use SuperMetrics\Domain\ResourceRepository;

class SuperMetricsRepository implements ResourceRepository
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Credentials
     */
    private $credentials;

    public function __construct(Client $client, Credentials $credentials)
    {
        $this->client = $client;
        $this->credentials = $credentials;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $params
     * @param bool $refreshToken
     * @return ResponseInterface
     */
    public function request($method = "POST", $endpoint = "", $params = [], $refreshToken = false) : ResponseInterface
    {
        $options['query'] = array_merge($params, ['sl_token' => $this->getToken($refreshToken)]);

        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (ConnectException $exception) {
            //something is wrong. log it
            $logger = new Logger($params, $exception);
            $response = new Response(500, [], []);
        } catch (BadResponseException $exception) {
            //token is expired, refresh it.
            $response = $this->request($method, $endpoint, $params, true);
        }

        return $response;
    }

    public function getToken($refresh = false)
    {
        //if token is saved, get token
        if (is_file(CACHE_DIR . "token") && $refresh === false) {
            return file_get_contents(CACHE_DIR . "token");
        }

        //if saved token is expired refresh token.
        $response = $this->requestToken();

        //save refreshed token.
        if ($response->getStatusCode() === 200) {
            $token = json_decode($response->getBody()->getContents(), true);
            file_put_contents(CACHE_DIR . "token", $token['data']['sl_token']);

            return $token['data']['sl_token'];
        } else {
            file_put_contents(LOG_DIR . "supermetrics.api.log", $response->getBody()->getContents() . PHP_EOL, FILE_APPEND);
            throw new ServerException("cant get token");
        }
    }

    /**
     * @param int $page
     * @return mixed
     */
    public function getPosts($page = 1)
    {
        //create array of Posts[]
        $posts = [];
        $response = $this->request("GET", "assignment/posts", ['page'  => $page]);
        $response = json_decode($response->getBody()->getContents(), true);
        foreach ($response['data']['posts'] as $item) {
            $posts[] = new Post($item);
        }

        return $posts;
    }

    /**
     * @return ResponseInterface
     */
    private function requestToken() : ResponseInterface
    {
        $params = [
            'form_params' => [
                'client_id' => $this->credentials->getClientId(),
                'email' => $this->credentials->getClientEmail(),
                'name' => $this->credentials->getClientName()
            ]
        ];

        return $this->client->request("POST", "assignment/register", $params);
    }
}

<?php

namespace Tests;

use SuperMetrics\Domain\Post;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $postsResponse;

    protected $invalidTokenResponse;

    public function getPosts($raw = false)
    {
        ob_start();
        require(__DIR__ . '/stubs/posts.json');
        $ob = ob_get_clean();

        $postData =  json_decode($ob, true);

        if ($raw) {
            return $postData;
        }

        $posts = [];
        if (!isset($postData['data']['posts'])) return $posts;

        foreach ($postData['data']['posts'] as $item) {
            $posts[] = new Post($item);
        }

        return $posts;
    }

    public function getInvalidTokenResponse()
    {
        ob_start();
        require_once __DIR__ . '/stubs/invalid_token.json';
        $ob = ob_get_clean();
        return json_decode($ob, true);
    }
}

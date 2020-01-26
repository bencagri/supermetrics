<?php

namespace Tests\Infrastructre\External;

use SuperMetrics\Domain\Post;
use SuperMetrics\Infrastructure\External\Api\SuperMetricsRepository;
use Tests\TestCase;

class SuperMetricsApiTest extends TestCase
{
    public function testInvalidTokenRequest()
    {
        $mock = $this
            ->getMockBuilder(SuperMetricsRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['getToken'])
            ->getMock();

        $mock->method('getToken')
            ->with(false)
            ->willReturn($this->getInvalidTokenResponse());

        $this->assertArrayHasKey("error", $mock->getToken(false));
    }

    public function testGetPosts()
    {
        $mock = $this
            ->getMockBuilder(SuperMetricsRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPosts'])
            ->getMock();

        $mock->method('getPosts')
            ->with(1)
            ->willReturn($this->getPosts());

        $posts = $mock->getPosts(1);

        $this->assertSame(9, count($posts));
        $this->assertIsArray($posts);

        $first=$posts[0];
        $this->assertInstanceOf(Post::class, $first);
        $this->assertEquals('Lael Vassel', $first->getFromName());
    }
}

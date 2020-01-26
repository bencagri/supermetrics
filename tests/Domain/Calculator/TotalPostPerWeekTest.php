<?php

namespace Tests\Domain\Calculator;

use SuperMetrics\Domain\Calculator\TotalPostsPerWeek;
use Tests\TestCase;

class TotalPostPerWeekTest extends TestCase
{
    public function testTotalPostPerWeek()
    {
        $posts = $this->getPosts();

        $calculator = new TotalPostsPerWeek();
        $stats = $calculator->calculate($posts);

        $this->assertIsArray($stats);
        $this->assertSame(2, count($stats));

        $this->assertSame(2, $stats['32']);
        $this->assertSame(7, $stats['30']);
    }

    public function testEmptyResponse()
    {
        $posts = [];
        $calculator = new TotalPostsPerWeek();
        $stats = $calculator->calculate($posts);

        $this->assertEmpty($stats);
    }
}

<?php

namespace Tests\Domain\Calculator;

use SuperMetrics\Domain\Calculator\MaximumPostLengthByMonth;
use Tests\TestCase;

class MaximumPostLengthByMonthTest extends TestCase
{
    public function testMaximumPostLengthByMonth()
    {
        $posts = $this->getPosts();

        $calculator = new MaximumPostLengthByMonth();
        $stats = $calculator->calculate($posts);

        $this->assertIsArray($stats);
        $this->assertSame(2, count($stats));

        $this->assertSame(579, $stats['07']); //max of july
        $this->assertSame(73, $stats['08']); //max of august
    }

    public function testEmptyResponse()
    {
        $posts = [];
        $calculator = new MaximumPostLengthByMonth();
        $stats = $calculator->calculate($posts);

        $this->assertEmpty($stats);
    }
}

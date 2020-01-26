<?php

namespace Tests\Domain\Calculator;

use SuperMetrics\Domain\Calculator\AveragePostByUserPerMonth;
use Tests\TestCase;

class AveragePostByUserPerMonthTest extends TestCase
{
    public function testAverageUserPostPerMonth()
    {
        $posts = $this->getPosts();
        $calculator = new AveragePostByUserPerMonth();
        $stats = $calculator->calculate($posts);

        $this->assertIsArray($stats);
        $this->assertSame(2, count($stats));

        $this->assertSame(1.17, $stats['07']); //average of july
        $this->assertSame(1.0, $stats['08']); //average of august
    }
}

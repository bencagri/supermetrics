<?php

namespace Tests\Domain\Calculator;

use SuperMetrics\Domain\Calculator\AverageCharacterLengthOfPost;
use Tests\TestCase;

class __AverageCharacterLenghtOfPostTest extends TestCase
{
    public function testAveragePostLengthCalculator()
    {
        $posts = $this->getPosts();
        $calculator = new AverageCharacterLengthOfPost();
        $stats = $calculator->calculate($posts);

        $this->assertIsArray($stats);
        $this->assertSame(2, count($stats));

        $this->assertSame(372.71, $stats['07']); //average of july
        $this->assertSame(69.5, $stats['08']); //average of august
    }

    public function testEmptyResponse()
    {
        $posts = [];
        $calculator = new AverageCharacterLengthOfPost();
        $stats = $calculator->calculate($posts);

        $this->assertEmpty($stats);
    }
}

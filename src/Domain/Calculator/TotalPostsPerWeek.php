<?php

namespace SuperMetrics\Domain\Calculator;

use SuperMetrics\Domain\CalculatorInterface;
use SuperMetrics\Domain\Post;

class TotalPostsPerWeek implements CalculatorInterface
{

    /**
     * @param array $payload
     * @return array|Post[]
     */
    public function calculate(array $payload)
    {
        $stats = [];
        foreach ($payload as $post) {
            /** @var Post $post */
            $week = $post->getCreatedAt()->format("W");
            $stats[$week] = (isset($stats[$week]) ? $stats[$week] : 0);
            $stats[$week]++;
        }

        return $stats;
    }

    /**
     * Name of calculator
     * @return string
     */
    public function name() : string
    {
        return "totalPostsPerWeek";
    }
}

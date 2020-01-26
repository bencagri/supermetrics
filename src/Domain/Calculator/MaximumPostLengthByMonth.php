<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 26/01/2020
 * Time: 13:42
 */

namespace SuperMetrics\Domain\Calculator;

use SuperMetrics\Domain\CalculatorInterface;
use SuperMetrics\Domain\Post;

class MaximumPostLengthByMonth implements CalculatorInterface
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
            $month = $post->getCreatedAt()->format("m");
            $stats[$month] = (isset($stats[$month]) ? $stats[$month] : 0);
            $stats[$month] = max($stats[$month], strlen($post->getMessage()));
        }

        return $stats;
    }

    /**
     * Name of calculator
     * @return string
     */
    public function name() : string
    {
        return 'maximumPostLengthByMonth';
    }
}

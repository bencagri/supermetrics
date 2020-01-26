<?php

namespace SuperMetrics\Domain\Calculator;

use SuperMetrics\Domain\CalculatorInterface;
use SuperMetrics\Domain\Post;

class AverageCharacterLengthOfPost implements CalculatorInterface
{

    /**
     * @param array $payload
     * @return array|Post[]
     */
    public function calculate(array $payload)
    {
        $tmp = [];

        foreach ($payload as $post) {
            /** @var Post $post */
            $month = $post->getCreatedAt()->format("m");

            $tmp[$month] = (isset($tmp[$month]) ? $tmp[$month] : ['total' => 0, 'sum' => 0]);
            $tmp[$month]['total']++;
            $tmp[$month]['sum'] += strlen($post->getMessage());
        }

        $stats = [];
        array_walk($tmp, function ($data, $month) use (&$stats) {
            $stats[$month] = $data['total'] > 0 ? round($data['sum'] / $data['total'], 2) : 0;
            return $stats;
        });


        return $stats;
    }

    /**
     * Name of calculator
     * @return string
     */
    public function name() : string
    {
        return "averageCharacterLengthOfMonth";
    }
}

<?php

namespace SuperMetrics\Domain\Calculator;

use SuperMetrics\Domain\CalculatorInterface;
use SuperMetrics\Domain\Post;

class AveragePostByUserPerMonth implements CalculatorInterface
{

    /**
     * @param array $payload
     * @return array|Post[]
     */
    public function calculate(array $payload)
    {
        $stats = [];

        $userTotalPosts = $this->getUserTotalPostsPerMonth($payload);

        foreach ($userTotalPosts as $month => $monthData) {
            $userCount = 0;
            $postCount = 0;

            foreach ($monthData as $userPostCount) {
                $userCount++;
                $postCount += $userPostCount;
            }
            $stats[$month] = $userCount > 0 ? round($postCount / $userCount, 2) : 0;
        }

        return $stats;
    }

    /**
     * Name of calculator
     * @return string
     */
    public function name() : string
    {
        return 'averagePostByUserPerMonth';
    }

    /**
     * Gets users total posts per month
     * @param $payload
     * @return array
     */
    private function getUserTotalPostsPerMonth($payload)
    {
        $userData = [];

        foreach ($payload as $post) {
            /** @var Post $post */
            $month = $post->getCreatedAt()->format("m");
            $userData[$month] = (isset($userData[$month]) ? $userData[$month] : []);
            $userData[$month][$post->getFromId()] =
                (isset($userData[$month][$post->getFromId()]) ? $userData[$month][$post->getFromId()] : 0);
            $userData[$month][$post->getFromId()]++;
        }

        return $userData;
    }
}

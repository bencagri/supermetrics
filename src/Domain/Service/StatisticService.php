<?php

namespace SuperMetrics\Domain\Service;

use SuperMetrics\Domain\Calculator\AverageCharacterLengthOfPost;
use SuperMetrics\Domain\Calculator\AveragePostByUserPerMonth;
use SuperMetrics\Domain\Calculator\MaximumPostLengthByMonth;
use SuperMetrics\Domain\Calculator\TotalPostsPerWeek;
use SuperMetrics\Domain\CalculatorInterface;
use SuperMetrics\Domain\Post;
use SuperMetrics\Domain\ResourceRepository;

class StatisticService
{

    /**
     * @var ResourceRepository
     */
    private $repository;

    /**
     * @var array of calculators
     */
    private $calculators = [
        AverageCharacterLengthOfPost::class,
        MaximumPostLengthByMonth::class,
        TotalPostsPerWeek::class,
        AveragePostByUserPerMonth::class
    ];

    public function __construct(ResourceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function all()
    {
        $posts = $this->getPosts();
        $calculatedStats = [];
        foreach ($this->calculators as $calculator) {
            $calculatedStats = array_merge($calculatedStats, $this->getStatsByCalculator(new $calculator, $posts));
        }
        return $calculatedStats;
    }

    /**
     * @return Post[]
     */
    public function getPosts()
    {
        $posts = [];

        for ($i = 1; $i <= ResourceRepository::MAX_PAGE; $i++) {
            $posts = array_merge($posts, $this->repository->getPosts($i));
        }

        return $posts;
    }

    /**
     * @param CalculatorInterface $calculator
     * @param $posts
     * @return array
     */
    public function getStatsByCalculator(CalculatorInterface $calculator, $posts)
    {
        return [$calculator->name() => $calculator->calculate($posts)];
    }
}

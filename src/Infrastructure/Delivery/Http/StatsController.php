<?php

namespace SuperMetrics\Infrastructure\Delivery\Http;

use Psr\Http\Message\ResponseInterface;
use SuperMetrics\Application\Shared\JsonResponse;
use SuperMetrics\Domain\Calculator\AverageCharacterLengthOfPost;
use SuperMetrics\Domain\Calculator\AveragePostByUserPerMonth;
use SuperMetrics\Domain\Calculator\MaximumPostLengthByMonth;
use SuperMetrics\Domain\Calculator\TotalPostsPerWeek;
use SuperMetrics\Domain\Service\StatisticService;

class StatsController
{

    /**
     * @var StatisticService
     */
    private $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    /**
     * Controller.
     * @return ResponseInterface
     *
     */
    public function all() : ResponseInterface
    {
        try {
            $body     = $this->statisticService->all();
            return new JsonResponse($body);
        } catch (\Exception $e) {
            return new JsonResponse([ "code" => $e->getCode(),"error" => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }

    /**
     * Controller.
     * @return ResponseInterface
     *
     */
    public function averageCharacterLengthOfPost() : ResponseInterface
    {
        try {
            $posts = $this->statisticService->getPosts();
            $body     = $this->statisticService->getStatsByCalculator(new AverageCharacterLengthOfPost(), $posts);
            return new JsonResponse($body);
        } catch (\Exception $e) {
            return new JsonResponse([ "code" => $e->getCode(),"error" => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }

    /**
     * Controller.
     * @return ResponseInterface
     *
     */
    public function averagePostByUserPerMonth() : ResponseInterface
    {
        try {
            $posts = $this->statisticService->getPosts();
            $body     = $this->statisticService->getStatsByCalculator(new AveragePostByUserPerMonth(), $posts);
            return new JsonResponse($body);
        } catch (\Exception $e) {
            return new JsonResponse([ "code" => $e->getCode(),"error" => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }

    /**
     * Controller.
     * @return ResponseInterface
     *
     */
    public function maximumPostLengthByMonth() : ResponseInterface
    {
        try {
            $posts = $this->statisticService->getPosts();
            $body     = $this->statisticService->getStatsByCalculator(new MaximumPostLengthByMonth(), $posts);
            return new JsonResponse($body);
        } catch (\Exception $e) {
            return new JsonResponse([ "code" => $e->getCode(),"error" => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }

    /**
     * Controller.
     * @return ResponseInterface
     *
     */
    public function totalPostsPerWeek() : ResponseInterface
    {
        try {
            $posts = $this->statisticService->getPosts();
            $body     = $this->statisticService->getStatsByCalculator(new TotalPostsPerWeek(), $posts);
            return new JsonResponse($body);
        } catch (\Exception $e) {
            return new JsonResponse([ "code" => $e->getCode(),"error" => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }
}

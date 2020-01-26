<?php

namespace SuperMetrics\Infrastructure\Delivery\Http;

use Psr\Http\Message\ResponseInterface;
use SuperMetrics\Application\Shared\JsonResponse;
use SuperMetrics\Domain\Service\StatisticService;

class MainController
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
    public function index() : ResponseInterface
    {
        try {
            $body = [
                "endpoints" => [
                    "averageCharacterLengthOfPost" => [
                            "method" => "GET",
                            "uri" => "/stats/averageCharacterLengthOfPost"
                        ],
                    "averagePostByUserPerMonth" => [
                        "method" => "GET",
                        "uri" => "/stats/averagePostByUserPerMonth"
                    ],
                    "maximumPostLengthByMonth" => [
                        "method" => "GET",
                        "uri" => "/stats/maximumPostLengthByMonth"
                    ],
                    "totalPostsPerWeek" => [
                        "method" => "GET",
                        "uri" => "/stats/totalPostsPerWeek"
                    ],
                    "all" => [
                        "method" => "GET",
                        "uri" => "/stats"
                    ]
                ]
            ];
            return new JsonResponse($body);
        } catch (\Exception $e) {
            return new JsonResponse(["code" => $e->getCode(), "error" => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }
}

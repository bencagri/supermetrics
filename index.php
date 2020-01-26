<?php declare(strict_types=1);


if (!file_exists("vendor/autoload.php")) {
    exit("Forget composer install??");
}

if (!file_exists(".env")) {
    exit("Forget creating .env file??");
}

require_once "vendor/autoload.php";
DEFINE("CACHE_DIR", __DIR__ . '/var/cache/');
DEFINE("LOG_DIR", __DIR__ . '/var/log/');

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\ServerRequest;
use League\Container\Container;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use SuperMetrics\Application\Client\Credentials;
use SuperMetrics\Domain\ResourceRepository;
use SuperMetrics\Domain\Service\StatisticService;
use SuperMetrics\Infrastructure\Delivery\Http\MainController;
use SuperMetrics\Infrastructure\Delivery\Http\StatsController;
use SuperMetrics\Infrastructure\External\Api\SuperMetricsRepository;

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

$container = new Container;

//set dependencies
$container->add(MainController::class)->addArgument(StatisticService::class);
$container->add(StatsController::class)->addArgument(StatisticService::class);
$container->add(StatisticService::class)->addArgument(ResourceRepository::class);


$container->add(ResourceRepository::class, SuperMetricsRepository::class)
    ->addArgument(ClientInterface::class)
    ->addArgument(Credentials::class)
;

$container->add(ClientInterface::class, GuzzleHttp\Client::class)
    ->addArgument([
        'base_uri' => getenv("API_BASE_URL"),
        'timeout'  => 2.0,
    ])
;

$container->add(Credentials::class)
    ->addArgument(getenv("CLIENT_ID"))
    ->addArgument(getenv("CLIENT_EMAIL"))
    ->addArgument(getenv("CLIENT_NAME"))
;


$strategy = (new ApplicationStrategy)->setContainer($container);
$router   = new Router();
$router->setStrategy($strategy);

//set routes
$router->map('GET', '/', [MainController::class, "index"]);
$router->get('/stats/averageCharacterLengthOfPost', [StatsController::class, "averageCharacterLengthOfPost"]);
$router->get('/stats/averagePostByUserPerMonth', [StatsController::class, "averagePostByUserPerMonth"]);
$router->get('/stats/maximumPostLengthByMonth', [StatsController::class, "maximumPostLengthByMonth"]);
$router->get('/stats/totalPostsPerWeek', [StatsController::class, "totalPostsPerWeek"]);
$router->get('/stats', [StatsController::class, "all"]);
//handle request
try {
    $request = ServerRequest::fromGlobals();
    $response = $router->dispatch($request);
    (new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
} catch (Exception $e) {
    http_response_code(500);
    $message = json_encode([
        'error' => $e->getMessage(),
        'thrace' => $e->getTrace()
    ]);
    echo $message;
}

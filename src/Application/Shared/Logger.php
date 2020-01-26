<?php

namespace SuperMetrics\Application\Shared;

/**
 * Simple Logger
 * Class Logger
 *
 * @package SuperMetrics\Application\Shared
 */
class Logger
{
    public function __construct($logData = "", \Exception $exception = null)
    {
        file_put_contents(LOG_DIR . "supermetrics.api.log", $exception->getMessage() . PHP_EOL, FILE_APPEND);
    }
}

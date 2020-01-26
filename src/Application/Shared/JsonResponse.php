<?php

namespace SuperMetrics\Application\Shared;

use GuzzleHttp\Psr7\Response;

/**
 * Class JsonResponse
 * @package SuperMetrics\Application\Shared
 */
class JsonResponse extends Response
{
    public function __construct(
        $data,
        $status = 200,
        array $headers = [],
        $version = '1.1',
        $reason = null
    ) {
        if (!is_array($data) || !is_object($data)) {
            $data = [$data];
        }
        $headers = ['Content-Type' => 'application/json'];
        parent::__construct($status, $headers, json_encode($data, JSON_PRETTY_PRINT), $version, $reason);
    }
}

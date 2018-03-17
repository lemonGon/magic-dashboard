<?php

namespace App\Traits;

/**
 * Trait output
 * @package App\Traits
 */
trait OutputTrait
{
    /**
     * Application common json output format
     *
     * @param array $payload
     * @param string $status
     * @param int $httpStatusCode
     * @return string
     */
    public static function jsonOutput(array $payload, $status, $httpStatusCode = 200)
    {
        return json_encode([
            'status' => $status,
            'httpStatusCode' => $httpStatusCode,
            'payload' => $payload
        ]);
    }
}

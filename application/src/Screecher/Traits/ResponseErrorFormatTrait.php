<?php

namespace Screecher\Traits;

/**
 * trait ResponseErrorFormatTrait
 * @package Screecher\Traits
 */
trait ResponseErrorFormatTrait
{
    /**
     * @param $statusCode
     * @param $message
     * @return array
     */
    public function formatError($statusCode, $message)
    {
        return ['status' => $statusCode, 'message' => $message];
    }
}
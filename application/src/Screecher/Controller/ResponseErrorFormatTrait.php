<?php

namespace Screecher\Controller;


/**
 * Class ResponseErrorFormatTrait
 * @package Screecher\Controller
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
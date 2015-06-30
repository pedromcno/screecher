<?php

namespace Screecher\Service\Interfaces;

/**
 * Interface EmailProviderInterface
 * @package Screecher\Service
 */
interface EmailProviderInterface {

    /**
     * @param string $subject
     * @param string $content
     * @param array $sendTo
     * @return mixed
     */
    public function sendEmail($subject, $content, $sendTo);

}
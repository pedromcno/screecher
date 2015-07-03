<?php

namespace Screecher\Service;

use Mandrill;
use Screecher\Service\Interfaces\EmailProviderInterface;
use Monolog\Logger;

/**
 * Class MandrillAdapter
 * @package Screecher\Service
 */
class MandrillAdapter implements EmailProviderInterface
{
    const DEFAULT_IP_POOL = 'Main Pool';

    const ASYNC_TRUE = 'true';

    const ASYNC_FALSE = 'false';

    const DEFAULT_RECIPIENT_TYPE = 'to';

    private $settings;

    /** @var  Logger */
    private $monologLogger;

    public function __construct($settings, $monologLogger){
        $this->settings = $settings;
        $this->monologLogger = $monologLogger;
    }

    /**
     * @param string $subject
     * @param string $template
     * @param array $sendTo
     * @return array | false
     * @throws \Exception
     */
    public function sendEmail($subject, $template, $sendTo)
    {
        try {
            $mandrill = new Mandrill($this->settings['key']);

            $message = array(
                'html' => $template,
                'subject' => $subject,
                'from_email' => $this->settings['senderEmail'],
                'from_name' => $this->settings['senderName'],
                'to' => $this->formatRecipients($sendTo)
            );

            return $mandrill->messages->send($message, self::ASYNC_FALSE, self::DEFAULT_IP_POOL);
        } catch(\Exception $e) {
            $this->monologLogger->addDebug($e->getMessage());
            return false;
        }
    }


    /**
     * @param $messageId
     * @return \struct
     * @throws Mandrill_Error
     */
    public function getMessageInfo($messageId)
    {
        try {
            $mandrill = new Mandrill($this->settings['key']);
            return $mandrill->messages->info($messageId);
        } catch(\Exception $e) {
            $this->monologLogger->addDebug($e->getMessage());
            return false;
        }
    }


    /**
     * @param $recipients
     * @return array
     */
    private function formatRecipients($recipients)
    {
        $formattedRecipients = [];

        foreach ($recipients as $recipient)
        {
            $formattedRecipients[] = [
                'email' => $recipient,
                'name' => 'Maintainer',
                'type' => self::DEFAULT_RECIPIENT_TYPE
            ];
        }

        return $formattedRecipients;
    }

}
<?php
namespace Screecher\Service;

use Mandrill;
use Screecher\Service\Interfaces\EmailProviderInterface;

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

    public function __construct($settings){
        $this->settings = $settings;
    }

    /**
     * @param string $subject
     * @param string $template
     * @param array $sendTo
     * @return array | false
     * @throws Mandrill_Error
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
        } catch(Mandrill_Error $e) {
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
        try
        {
            $mandrill = new Mandrill($this->settings['key']);
            return $mandrill->messages->info($messageId);
        } catch(Mandrill_Error $e) {
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
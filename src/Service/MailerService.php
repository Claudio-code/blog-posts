<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;

class MailerService
{
    private Swift_Mailer $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param array $data
     * @param $view
     */
    public function execute($view, array $data = []): int
    {
        if (empty($data)) {
            return 0;
        }

        $message = new Swift_Message($data['subject']);
        $message->setFrom('casaNova@gmail.com');
        $message->setTo($data['email']);
        $message->setBody($view, 'text/html');

        return $this->mailer->send($message);
    }
}
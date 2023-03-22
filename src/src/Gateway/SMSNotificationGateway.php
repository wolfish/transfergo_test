<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Enum\NotificationType;
use App\Message\MessageInterface;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Component\Notifier\Message\SmsMessage;

class SMSNotificationGateway implements NotificationGatewayInterface
{

    protected NotificationType $type;

    protected MessageInterface $message;

    private TexterInterface $texter;

    public function __construct(TexterInterface $texter)
    {
        $this->setType(NotificationType::SMS);
        $this->texter = $texter;
    }

    public function send() : bool
    {
        $sms = new SmsMessage(
            $this->message->getRecipient(),
            $this->message->getMessageText()
        );

        $sentMessage = $this->texter->send($sms);

        return true;
    }

    public function setMessage(MessageInterface $message) : self
    {
        $this->message = $message;
        return $this;
    }

    public function getType() : NotificationType
    {
        return $this->type;
    }

    public function setType(NotificationType $type) : self
    {
        $this->type = $type;
        return $this;
    }

    protected function incorrectMessageType() : void
    {
        throw new \Exception('Incorrect message class ' . $this->message::class . ' for gateway ' . self::class);
    }

}

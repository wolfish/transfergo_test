<?php

namespace App\Message;

use App\Enum\NotificationType;

use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Notification\SmsNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\SmsRecipientInterface;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\MessageOptionsInterface;

class SMSNotificationMessage implements NotificationMessageInterface
{

    private NotificationType $type;

    private ?string $userId;

    private ?string $uniqueId;

    private ?string $recipient;

    private ?string $messageText;

    public function __construct(
        string $phone, 
        string $subject,
        ?string $userId = null, 
        ?string $uniqueId = null
    )
    {
        $this->userId = $userId;
        $this->uniqueId = $uniqueId;
        $this->recipient = $phone;
        $this->messageText = $subject;
        $this->type = NotificationType::SMS;
    }

    public function getNotifierObject() : SmsMessage
    {
        return new SmsMessage(
            $this->getRecipient(),
            $this->getMessageText()
        );
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getMessageText(): string
    {
        return $this->messageText;
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

    public function getUserId() : ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUniqueId() : ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(?string $uniqueId) : self
    {
        $this->userId = $uniqueId;
        return $this;
    }
    

}

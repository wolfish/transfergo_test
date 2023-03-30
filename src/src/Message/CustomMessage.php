<?php

declare(strict_types=1);

namespace App\Message;

use App\Enum\NotificationType;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\SmsRecipientInterface;

class CustomMessage extends SmsMessage implements NotificationMessageInterface
{
    private NotificationType $type;
    private ?string $userId;
    private ?string $uniqueId;

    public function __construct(
        string $phone, 
        string $subject, 
        NotificationType $type,
        string $from = '',
        ?string $userId = null,
        ?string $uniqueId = null
    ) 
    {
        $this->userId = $userId;
        $this->uniqueId = $uniqueId;
        $this->type = $type;

        return parent::__construct($phone, $subject, $from);
    }

    /**
     * @param SMSNotification $notification
     */
    public static function fromNotification(
        Notification $notification, 
        SmsRecipientInterface $recipient
    ): self
    {
        return new self(
            $recipient->getPhone(), 
            $notification->getSubject(), 
            type: $notification->getType(),
            userId: $notification->getUserId(), 
            uniqueId: $notification->getUniqueId()
        );
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
        $this->uniqueId = $uniqueId;
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

}

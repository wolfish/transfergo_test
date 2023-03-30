<?php

declare(strict_types=1);

namespace App\Notification;

use App\Enum\NotificationType;
use App\Message\CustomMessage;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Notification\SmsNotificationInterface;
use Symfony\Component\Notifier\Recipient\SmsRecipientInterface;

class SMSNotification extends Notification implements SmsNotificationInterface
{

    private NotificationType $type;

    private ?string $userId;

    private ?string $uniqueId;

    public function __construct(
        string $subject,
        array $channels,
        ?string $userId = null,
        ?string $uniqueId = null
    ) 
    {
        $this->userId = $userId;
        $this->uniqueId = $uniqueId;
        $this->type = NotificationType::SMS;

        return parent::__construct($subject, $channels);
    }

    public function asSmsMessage(SmsRecipientInterface $recipient, string $transport = null) : ?SmsMessage
    {
        return CustomMessage::fromNotification($this, $recipient);
    }

    public function getUserId() : ?string
    {
        return $this->userId;
    }

    public function getUniqueId() : ?string
    {
        return $this->uniqueId;
    }

    public function getType() : NotificationType
    {
        return $this->type;
    }

}

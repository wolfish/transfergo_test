<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Entity\NotificationMessage;
use App\Enum\NotificationType;
use App\Message\NotificationMessageInterface;
use App\Notification\SMSNotification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class SMSNotificationGateway implements NotificationGatewayInterface
{

    private NotificationType $type;

    private NotifierInterface $notifier;

    private NotificationMessage $notification;

    public function __construct(
        NotifierInterface $notifier, 
        NotificationMessage $notification
    )
    {
        $this->setType(NotificationType::SMS);
        $this->notifier = $notifier;
        $this->notification = $notification;
    }

    public function send() : bool
    {
        $notification = new SMSNotification(
            $this->notification->getMessageText(), 
            ['sms'],
            $this->notification->getUserId(),
            $this->notification->getUniqueId()
        );

        $recipient = new Recipient(
            $this->getType() === NotificationType::EMAIL ?? $this->notification->getRecipient(),
            $this->getType() === NotificationType::SMS ?? $this->notification->getRecipient()
        );

        $this->notifier->send($notification, $recipient);

        return true;
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

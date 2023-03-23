<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Entity\NotificationMessage;
use App\Enum\NotificationType;
use App\Message\NotificationMessageInterface;
use App\Message\SMSNotificationMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class SMSNotificationGateway implements NotificationGatewayInterface
{

    private NotificationType $type;

    private SMSNotificationMessage $message;

    private NotifierInterface $notifier;

    private NotificationMessage $notification;

    private EntityManagerInterface $manager;

    public function __construct(
        NotifierInterface $notifier, 
        NotificationMessage $notification, 
        EntityManagerInterface $manager
    )
    {
        $this->setType(NotificationType::SMS);
        $this->notifier = $notifier;
        $this->notification = $notification;
        $this->manager = $manager;
    }

    public function send() : bool
    {
        $notification = new Notification(
            $this->message->getMessageText(), 
            ['sms']
        );

        $recipient = new Recipient(
            phone: $this->message->getRecipient()
        );

        try {
            $this->notifier->send($notification, $recipient);
        } catch (\Exception $e) {
            $this->updateNotificationMessage($this->notification, false);
            return false;
        }

        $this->updateNotificationMessage($this->notification, true);
        return true;
    }

    public function setMessage(NotificationMessageInterface $message) : self
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

    private function updateNotificationMessage(
        NotificationMessage $notificationMessage,
        bool $isSent
    ) : NotificationMessage
    {
        $notificationMessage->setIsSent($isSent);
        $notificationMessage->setUpdated(new \DateTime('now'));

        $this->manager->persist($notificationMessage);
        $this->manager->flush();

        return $notificationMessage;
    }

    

}

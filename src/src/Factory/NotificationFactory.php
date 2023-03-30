<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\NotificationMessage;
use App\Enum\NotificationType;
use App\Gateway\NotificationGatewayInterface;
use App\Gateway\SMSNotificationGateway;
use App\Input\NotificationInputInterface;
use App\Message\CustomMessage;
use App\Message\NotificationMessageInterface;
use App\Message\SMSNotificationMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\TexterInterface;

class NotificationFactory
{

    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function createGateway(
        NotifierInterface $transport,
        NotificationMessage $notification
    ) : NotificationGatewayInterface
    {
        switch ($notification->getType()) {
            
            case NotificationType::SMS->value:
                $gateway = new SMSNotificationGateway($transport, $notification, $this->manager);
                break;

            default:
                throw new \Exception('Undefined notification type');

        }

        return $gateway;
    }

    public function createMessage(NotificationInputInterface $input) : NotificationMessageInterface
    {
        switch ($input->getType()) {
            
            case NotificationType::SMS->value:
                return new CustomMessage(
                    $input->getRecipient(),
                    $input->getMessageText(),
                    type: NotificationType::SMS,
                    userId: $input->getUserId(),
                    uniqueId: $input->getUniqueId()
                );

            default:
                throw new \Exception('Undefined notification type');

        }
    }
}

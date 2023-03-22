<?php

declare(strict_types=1);

namespace App\Factory;

use App\Enum\NotificationType;
use App\Gateway\NotificationGatewayInterface;
use App\Gateway\SMSNotificationGateway;
use App\Input\NotificationInputInterface;
use App\Message\MessageInterface;
use App\Message\SMSMessage;
use Symfony\Component\Notifier\TexterInterface;

class NotificationFactory
{

    public function createGateway(
        MessageInterface $message, 
        TexterInterface $transport
    ) : NotificationGatewayInterface
    {
        switch ($message->getType()) {
            
            case NotificationType::SMS:
                $gateway = new SMSNotificationGateway($transport);
                break;

            default:
                throw new \Exception('Undefined notification type');

        }

        $gateway->setMessage($message);
        return $gateway;
    }

    public function createMessage(NotificationInputInterface $input) : MessageInterface
    {
        switch ($input->getType()) {
            
            case NotificationType::SMS->value:
                return new SMSMessage(
                    $input->getRecipient(),
                    $input->getMessageText()
                );

            default:
                throw new \Exception('Undefined notification type');

        }
    }
}

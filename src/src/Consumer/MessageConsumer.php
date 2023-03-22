<?php

declare(strict_types=1);

namespace App\Consumer;

use App\Factory\NotificationFactory;
use App\Message\MessageInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Notifier\TexterInterface;

#[AsMessageHandler()]
class MessageConsumer
{

    private NotificationFactory $factory;

    private TexterInterface $transport;

    public function __construct(
        NotificationFactory $factory,
        TexterInterface $transport
    )
    {
        $this->factory = $factory;
        $this->transport = $transport;
    }

    public function __invoke(MessageInterface $message)
    {
        $gateway = $this->factory->createGateway($message, $this->transport);

        $result = $gateway->send();
        
        return $result;
    }

}

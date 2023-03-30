<?php

declare(strict_types=1);

namespace App\Consumer;

use App\Factory\NotificationFactory;
use App\Message\NotificationMessageInterface;
use App\Repository\NotificationMessageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\TexterInterface;

#[AsMessageHandler()]
class MessageConsumer
{

    private NotificationFactory $factory;

    private NotifierInterface $transport;

    private NotificationMessageRepository $repository;

    public function __construct(
        NotificationFactory $factory,
        NotifierInterface $transport,
        NotificationMessageRepository $repository
    )
    {
        $this->factory = $factory;
        $this->transport = $transport;
        $this->repository = $repository;
    }

    public function __invoke(NotificationMessageInterface $message) : bool
    {
        $notification = $this->repository->findOneBy([
            'unique_id' => $message->getUniqueId()
        ]);

        $gateway = $this->factory->createGateway($this->transport, $notification);
        
        return $gateway->send();
    }

}

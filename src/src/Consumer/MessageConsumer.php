<?php

declare(strict_types=1);

namespace App\Consumer;

use App\Entity\NotificationMessage;
use App\Factory\NotificationFactory;
use App\Input\NotificationInputInterface;
use App\Repository\NotificationMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Notifier\NotifierInterface;

#[AsMessageHandler()]
class MessageConsumer
{

    private NotificationFactory $factory;

    private NotifierInterface $transport;

    private EntityManagerInterface $manager;

    private NotificationMessageRepository $repository;

    public function __construct(
        EntityManagerInterface $manager,
        NotificationMessageRepository $repository,
        NotificationFactory $factory,
        NotifierInterface $transport
    )
    {
        $this->factory = $factory;
        $this->transport = $transport;
        $this->manager = $manager;
        $this->repository = $repository;
    }

    public function __invoke(NotificationInputInterface $message)
    {
        $notification = $this->repository->findOneBy([
            'unique_id' => $message->getUniqueId()
        ]);

        if (!$notification instanceof NotificationMessage) {
            $notification = $this->createNotificationMessage($message);
            $this->manager->persist($notification);
            $this->manager->flush();
        }

        $message = $this->factory->createMessage($message);
        $gateway = $this->factory->createGateway($this->transport, $notification);
        $gateway->send();
    }

    private function createNotificationMessage(NotificationInputInterface $input) : NotificationMessage
    {
        $notification = new NotificationMessage();
        $notification->setType($input->getType());
        $notification->setUserId($input->getUserId());
        $notification->setRecipient($input->getRecipient());
        $notification->setMessageText($input->getMessageText());
        $notification->setUniqueId($input->getUniqueId());
        $notification->setCreated(new \DateTime('now'));

        return $notification;
    }

}

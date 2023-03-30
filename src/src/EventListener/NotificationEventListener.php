<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Repository\NotificationMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\Event\FailedMessageEvent;
use Symfony\Component\Notifier\Event\SentMessageEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use App\Entity\NotificationMessage;
use App\Message\CustomMessage;

#[AsEventListener(event: SentMessageEvent::class, method: 'handleMessage')]
#[AsEventListener(event: FailedMessageEvent::class, method: 'handleMessage')]
class NotificationEventListener
{

    private NotificationMessageRepository $repository;

    private EntityManagerInterface $entityManager;

    public function __construct(NotificationMessageRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function handleMessage(SentMessageEvent|FailedMessageEvent $event) : void
    {
        /**
         * @var CustomMessage
         */
        $message = $event instanceof FailedMessageEvent ? 
            $event->getMessage() 
            : 
            $event->getMessage()->getOriginalMessage();

        $notificationMessage = $this->repository->findOneBy([
            'unique_id' => $message->getUniqueId()
        ]);

        $notificationMessage = $this->updateNotificationMessage($message, $notificationMessage);
        $notificationMessage->setIsSent($event instanceof SentMessageEvent);
        $notificationMessage->setErrorMessage(
            $event instanceof FailedMessageEvent ? 
                $event->getError()->getMessage() : null
        );

        $this->entityManager->persist($notificationMessage);
        $this->entityManager->flush();
    }


    private function updateNotificationMessage(
        CustomMessage $message,
        NotificationMessage $notificationMessage
    ) : NotificationMessage
    {
        $notificationMessage->setType($message->getType()->value);
        $notificationMessage->setUniqueId($message->getUniqueId());
        $notificationMessage->setUserId($message->getUserId());
        $notificationMessage->setRecipient($message->getPhone());
        $notificationMessage->setMessageText($message->getSubject());
        $notificationMessage->setUpdated(new \DateTime('now'));

        return $notificationMessage;
    }

}

<?php

declare(strict_types=1);

namespace App\Input;

use App\Enum\NotificationType;
use App\Repository\NotificationMessageRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class SMSNotificationInput implements NotificationInputInterface
{

    private string $type = NotificationType::SMS->value;

    private string $uniqueId;

    #[Assert\NotBlank()]
    #[Assert\Length(max: 100)]
    #[Assert\Regex(
        '/^\+(?:[0-9]){6,14}[0-9]$/', 
        message: 'This value should be correct phone number'
    )]
    private string $recipient;

    #[Assert\NotBlank()]
    #[Assert\Length(max: 500)]
    private ?string $messageText = null;

    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private string $userId;


    public function __construct(?string $uniqueId = null)
    {
        $this->uniqueId = $uniqueId ?? uniqid();
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function setType(string $type) : self
    {
        $this->type = $type;
        return $this;
    }

    public function getUniqueId() : string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId) : self
    {
        $this->uniqueId = $uniqueId;
        return $this;
    }

    public function getRecipient() : string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient) : self
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function getMessageText() : string
    {
        return $this->messageText;
    }

    public function setMessageText(string $messageText) : self
    {
        $this->messageText = $messageText;
        return $this;
    }

    public function getUserId() : string
    {
        return $this->userId;
    }

    public function setUserId(string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

}

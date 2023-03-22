<?php

declare(strict_types=1);

namespace App\Input;

use App\Enum\NotificationType;
use Symfony\Component\Validator\Constraints as Assert;

class SMSNotificationInput implements NotificationInputInterface
{

    private string $type = NotificationType::SMS->value;

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

    private bool $sent = false;

    public function getType() : string
    {
        return $this->type;
    }

    public function setType(string $type) : self
    {
        $this->type = $type;
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

    public function isSent() : bool
    {
        return $this->sent;
    }

    public function setSent(bool $sent) : self
    {
        $this->sent = $sent;
        return $this;
    }

}

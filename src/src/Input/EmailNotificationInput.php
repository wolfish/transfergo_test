<?php

declare(strict_types=1);

namespace App\Input;

use App\Enum\NotificationType;
use Symfony\Component\Validator\Constraints as Assert;

class EmailNotificationInput implements NotificationInputInterface
{
    private string $type = NotificationType::EMAIL->value;

    #[Assert\NotBlank()]
    #[Assert\Length(max: 100)]
    #[Assert\Email()]
    private ?string $recipient = null;

    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 100)]
    private ?string $senderName = null;

    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 100)]
    private ?string $messageTitle = null;

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

    public function getSenderName() : ?string
    {
        return $this->senderName;
    }

    public function setSenderName(?string $senderName) : self
    {
        $this->senderName = $senderName;
        return $this;
    }

    public function getMessageTitle() : ?string
    {
        return $this->messageTitle;
    }

    public function setMessageTitle(?string $messageTitle) : self
    {
        $this->messageTitle = $messageTitle;
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

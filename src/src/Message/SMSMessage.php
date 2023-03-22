<?php

namespace App\Message;

use App\Enum\NotificationType;

class SMSMessage implements MessageInterface
{

    protected NotificationType $type;

    protected string $phoneNumber;

    protected string $messageText;

    public function __construct(
        string $phoneNumber,
        string $messageText
    ) {
        $this->setType(NotificationType::SMS);
        $this->setRecipient($phoneNumber);
        $this->setMessageText($messageText);
    }

    public function getRecipient() : string
    {
        return $this->phoneNumber;
    }

    public function setRecipient(string $phoneNumber) : self
    {
        $this->phoneNumber = $phoneNumber;
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

    public function getType() : NotificationType
    {
        return $this->type;
    }

    public function setType(NotificationType $type) : self
    {
        $this->type = $type;
        return $this;
    }

}

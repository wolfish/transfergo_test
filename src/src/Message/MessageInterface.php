<?php

declare(strict_types=1);

namespace App\Message;

use App\Enum\NotificationType;

interface MessageInterface
{

    public function getType() : NotificationType;

    public function setType(NotificationType $type) : self;

    public function getRecipient() : string;

    public function setRecipient(string $recipient) : self;

    public function getMessageText() : string;

    public function setMessageText(string $messageText) : self;

}

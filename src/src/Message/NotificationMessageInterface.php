<?php

declare(strict_types=1);

namespace App\Message;

use App\Enum\NotificationType;

interface NotificationMessageInterface
{

    public function getType() : NotificationType;

    public function setType(NotificationType $type) : self;

    public function getUserId() : ?string;

    public function setUserId(?string $userId) : self;

    public function getUniqueId() : ?string;

    public function setUniqueId(?string $userId) : self;

}

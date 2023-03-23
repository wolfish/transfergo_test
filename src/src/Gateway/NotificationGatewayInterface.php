<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Message\NotificationMessageInterface;

interface NotificationGatewayInterface
{

    public function setMessage(NotificationMessageInterface $message) : self;

    public function send() : bool;

}

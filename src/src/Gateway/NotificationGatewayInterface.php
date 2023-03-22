<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Message\MessageInterface;

interface NotificationGatewayInterface
{

    public function setMessage(MessageInterface $message) : self;

    public function send() : bool;

}

<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Message\NotificationMessageInterface;

interface NotificationGatewayInterface
{

    public function send() : bool;

}

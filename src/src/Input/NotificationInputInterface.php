<?php

declare(strict_types=1);

namespace App\Input;

interface NotificationInputInterface
{

    public function getType() : string;

    public function getRecipient() : string;

    public function getMessageText() : string;
    
}

<?php
declare(strict_types=1);

namespace App\Enum;

enum NotificationType : string
{
    case EMAIL = 'email';
    case SMS   = 'sms';
}

<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Input\EmailNotificationInput;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class EmailNotificationParamConverter extends NotificationParamConverter implements ParamConverterInterface
{

    public function supports(ParamConverter $configuration) : bool
    {
        return $configuration->getConverter() === 'email_notification_param_converter';
    }

    public function apply(Request $request, ParamConverter $configuration) : void
    {
        $this->process($request, $configuration, EmailNotificationInput::class);
    }

}

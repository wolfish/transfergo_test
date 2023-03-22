<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ExceptionResponse;
use App\Factory\NotificationFactory;
use App\Input\SMSNotificationInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class NotificationController extends AbstractController
{
    #[Route(
        '/v1/api/notification/sms',
        name: 'v1_notification_sms_post',
        methods: ['POST']
    )]
    #[OA\Post(
        path: '/v1/api/notification/sms',
        description: 'Send notification by SMS',
        responses: [
            new OA\Response(response: 201, description: 'New notification created'),
            new OA\Response(response: 400, description: 'Input validation error'),
            new OA\Response(response: 500, description: 'Server error')
        ]
    )]
    #[OA\RequestBody(
        required: true,
        description: 'Notification parameters',
        content: [
            new OA\MediaType(
                'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'recipient', type: 'string', example: '+48000000000', description: 'Phone number of notification recipient with country prefix'),
                        //new OA\Property(property: 'senderName', type: 'string', example: 'sender@example.com', description: 'Sender information'),
                        //new OA\Property(property: 'messageTitle', type: 'string', example: 'Subject of email', description: 'Message title in type context - email subject, push title, SMS premium name'),
                        new OA\Property(property: 'messageText', type: 'string', example: 'Text of SMS message', description: 'Notification content')
                    ]
                )
            )
        ]
    )]
    #[OA\Tag('Notification')]
    #[ParamConverter('myMessage', converter: 'sms_notification_param_converter',)]
    public function smsNotification(
        Request $request, 
        NotificationFactory $factory,
        MessageBusInterface $queue,
        SMSNotificationInput $myMessage
    ): Response
    {
        $errors = $request->attributes->get('errors');
        if (count($errors)) {
            $response = new ExceptionResponse();
            return $response->validationErrorsResponse($errors);
        }

        $message = $factory->createMessage($myMessage);
        $queue->dispatch($message);
        return new Response('', 201);
    }
}

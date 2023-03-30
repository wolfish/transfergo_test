<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ExceptionResponse;
use App\Input\SMSNotificationInput;
use App\Repository\NotificationMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class NotificationController extends AbstractController
{

    private MessageBusInterface $queue;

    private NotificationMessageRepository $repository;

    public function __construct(
        MessageBusInterface $queue,
        NotificationMessageRepository $repository
    )
    {
        $this->queue = $queue;
        $this->repository = $repository;
    }

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
            new OA\Response(response: 429, description: 'Too many requests for user'),
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
                        new OA\Property(property: 'messageText', type: 'string', example: 'Text of SMS message', description: 'Notification content'),
                        new OA\Property(property: 'userId', type: 'string', example: '32194b72-91fa-43a2-a43c-87a34852fdc4', description: 'User identificator'),
                    ]
                )
            )
        ]
    )]
    #[OA\Tag('Notification')]
    #[ParamConverter('myMessage', converter: 'sms_notification_param_converter')]
    public function smsNotification(
        Request $request,
        SMSNotificationInput $myMessage
    ) : Response
    {
        $errors = $request->attributes->get('errors');
        if (count($errors)) {
            $response = new ExceptionResponse();
            return $response->validationErrorsResponse($errors);
        }

        $throttleResponse = $this->checkUserThrottle($myMessage->getUserId());
        if ($throttleResponse instanceof JsonResponse) {
            return $throttleResponse;
        }

        $this->queue->dispatch($myMessage);
        
        return new JsonResponse([
            'messageId' => $myMessage->getUniqueId()
        ], Response::HTTP_CREATED);
    }

    private function checkUserThrottle(string $userId) : ?JsonResponse
    {
        $limitDate = new \DateTime('now');
        $limitDate->sub(new \DateInterval('PT' . $this->getParameter('app.user_throttle_hours') . 'H'));

        $query = $this->repository->createQueryBuilder('nm')
            ->where('nm.user_id = :userId')
            ->andWhere('nm.created >= :limitDate')
            ->setParameter('userId', $userId)
            ->setParameter('limitDate', $limitDate)
            ->getQuery();

        $count = count($query->execute());

        if ($count >= (int)$this->getParameter('app.user_throttle_limit')) {
            $response = new ExceptionResponse();
            return $response->userThrottleResponse();
        }

        return null; 
    }
}

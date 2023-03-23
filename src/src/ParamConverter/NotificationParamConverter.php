<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Input\SMSNotificationInput;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;

abstract class NotificationParamConverter
{
    private SMSNotificationInput $notificationInput;

    private ValidatorInterface $validator;

    public function __construct(ManagerRegistry $registry, SMSNotificationInput $notificationInput, ValidatorInterface $validator)
    {
        $this->notificationInput = $notificationInput;
        $this->validator = $validator;
    }

    protected function process(Request $request, ParamConverter $configuration, string $inputClass)
    {
        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, $encoder);

        $this->notificationInput = $serializer->deserialize($request->getContent(), $inputClass, 'json');
        $errors = $this->validator->validate($this->notificationInput);

        $request->attributes->set($configuration->getName(), $this->notificationInput);
        $request->attributes->set('errors', $errors);
    }


}

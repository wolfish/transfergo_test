<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationList;

class ExceptionResponse extends JsonResponse
{

    public function validationErrorsResponse(ConstraintViolationList $errors) : self
    {
        $this->setStatusCode(self::HTTP_BAD_REQUEST);

        $formattedErrors = [];
        foreach ($errors as $violation) {
            $formattedErrors[$violation->getPropertyPath()][] = $violation->getMessage();
        }
        $this->setData([
            'message' => 'Request validation error',
            'code' => self::HTTP_BAD_REQUEST,
            'fields' => $formattedErrors
        ]);

        return $this;
    }

    public function userThrottleResponse() : self
    {
        $this->setStatusCode(self::HTTP_TOO_MANY_REQUESTS);
        $this->setData([
            'message' => 'Too many requests for this userId',
            'code' => self::HTTP_TOO_MANY_REQUESTS,
            'fields' => [
                'userId' => 'Too many requests'
            ]
        ]);

        return $this;
    }

}

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
            'code' => 0,
            'fields' => $formattedErrors
        ]);

        return $this;
    }

}

<?php

namespace App\RequestValidator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validation;

abstract class BaseRequestValidator
{
    protected function validate($data, $constraints): void
    {
        $validator = Validation::createValidator();
        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0)
        {
            $messages = [];
            foreach ($errors as $message)
            {
                $messages['errors'][] = [
                    'property' => $message->getPropertyPath(),
                    'value' => $message->getInvalidValue(),
                    'message' => $message->getMessage(),
                ];
            }

            (new JsonResponse($messages, 400))->send();
            exit;
        }
    }

    abstract function validated(array $data): array;
}

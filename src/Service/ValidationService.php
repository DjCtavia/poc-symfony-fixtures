<?php

namespace App\Service;

use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateAndReturnResponse(object $dto, array $groups = null): ?Response
    {
        try {
            $this->validate($dto, $groups);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'message' => 'Validation error',
                'errors' => $e->getErrors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        return null;
    }

    /**
     * @throws ValidationException
     */
    private function validate(object $dto, array $groups = null): void
    {
        $errors = $this->validator->validate($dto, null, $groups);

        if (count($errors) > 0) {
            $errorMessages = array_map(fn($error) => $error->getMessage(), iterator_to_array($errors));
            throw new ValidationException($errorMessages);
        }
    }
}
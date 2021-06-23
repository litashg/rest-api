<?php

declare(strict_types=1);

namespace App\Transformer;

use App\DTO\ErrorDTO;
use App\DTO\ResponseErrorDTOCollection;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorDTOTransformer
{
    public const MSG_VALIDATION_ERROR = 'Validation failed';

    public function getErrorDTO(string $field, string $code, string $message): ErrorDTO
    {
        return new ErrorDTO($field, $code, $message);
    }

    /**
     * @param ConstraintViolationListInterface<ConstraintViolationInterface> $errorRows
     *
     * @return ErrorDTO[]
     */
    public function getErrorDTOs(ConstraintViolationListInterface $errorRows): array
    {
        $errorFields = [];
        $errors = [];
        foreach ($errorRows as $errorRow) {
            $fieldName = $errorRow->getPropertyPath();
            if (in_array($fieldName, $errorFields, true)) {
                continue;
            }
            $errorFields[] = $fieldName;
            $errors[] = new ErrorDTO(
                $fieldName,
                $errorRow->getCode() ?? '',
                (string) $errorRow->getMessage()
            );
        }

        return $errors;
    }

    /**
     * @param int $httpCode
     * @param string $responseMessage
     * @param ErrorDTO[] $errors
     *
     * @return array<string, ResponseErrorDTOCollection>
     */
    public function prepareErrorResponse(
        int $httpCode,
        string $responseMessage,
        array $errors = []
    ): array {
        return [
            'error' => new ResponseErrorDTOCollection($httpCode, $responseMessage, $errors),
        ];
    }
}

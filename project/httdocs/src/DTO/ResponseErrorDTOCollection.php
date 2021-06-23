<?php

declare(strict_types=1);

namespace App\DTO;

use JsonSerializable;

class ResponseErrorDTOCollection implements JsonSerializable
{
    private int $httpCode;
    private string $responseMessage;
    private array $errors = [];

    public function __construct(int $httpCode, string $responseMessage, array $errors = [])
    {
        $this->httpCode = $httpCode;
        $this->responseMessage = $responseMessage;
        foreach ($errors as $errorDTO) {
            $this->addError($errorDTO);
        }
    }

    public function addError(ErrorDTO $errorDTO): void
    {
        foreach ($this->errors as $savedErrorDTO) {
            if ($errorDTO->getField() === $savedErrorDTO->getField()) {
                return;
            }
        }
        $this->errors[] = $errorDTO;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getResponseMessage(): string
    {
        return $this->responseMessage;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
    public function jsonSerialize(): array
    {
        return [
            'httpCode'        => $this->httpCode,
            'responseMessage' => $this->responseMessage,
            'errors'          => $this->errors,
        ];
    }
}

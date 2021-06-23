<?php

declare(strict_types=1);

namespace App\DTO;

use JsonSerializable;

class ErrorDTO implements JsonSerializable
{
    private string $field;
    private string $code;
    private string $message;

    public function __construct(string $field, string $code, string $message)
    {
        $this->field = $field;
        $this->code = $code;
        $this->message = $message;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function jsonSerialize(): array
    {
        return [
            'field'   => $this->field,
            'code'    => $this->code,
            'message' => $this->message,
        ];
    }
}

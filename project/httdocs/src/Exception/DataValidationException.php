<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

class DataValidationException extends Exception
{
    /**
     * @var array<array>
     */
    protected array $errors;

    /**
     * DataValidationException constructor.
     * @param string $message
     * @param array $errors
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', array $errors = [], int $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array<array>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}

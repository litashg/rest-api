<?php

declare(strict_types=1);

namespace App\Http;

use App\Transformer\ErrorDTOTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiErrorResponse extends JsonResponse
{
    public function __construct(
        string $message,
        $data = null,
        array $errors = [],
        int $status = Response::HTTP_OK,
        array $headers = [],
        bool $json = false
    ) {
        parent::__construct($this->format($message, $status, $data, $errors), $status, $headers, $json);
    }

    private function format(string $message, int $status, $data = null, array $errors = []): array
    {
        $transformer = new ErrorDTOTransformer();

        return $transformer->prepareErrorResponse($status, $message, $errors);
    }
}

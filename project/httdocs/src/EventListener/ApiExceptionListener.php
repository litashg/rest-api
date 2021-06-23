<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\DataValidationException;
use App\Http\ApiErrorResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ApiExceptionListener
{
    private const API_PREFIX = '/api/';

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        if ($this->isApiRequest($request)) {
            $response = $this->createApiResponse($exception, $request);
            $event->setResponse($response);
        }
    }

    private function isApiRequest(Request $request): bool
    {
        return str_contains($request->getRequestUri(), self::API_PREFIX);
    }

    private function createApiResponse(\Throwable $e, Request $request): ApiErrorResponse
    {
        if ($e instanceof DataValidationException) {
            return new ApiErrorResponse($e->getMessage(), null, $e->getErrors(), $e->getCode());
        }

        if ($e instanceof \InvalidArgumentException) {
            return new ApiErrorResponse($e->getMessage(), null, []);
        }

        if ($e instanceof HttpExceptionInterface) {
            return new ApiErrorResponse($e->getMessage(), null, [], $e->getStatusCode());
        }

        if ($e instanceof NotEncodableValueException) {
            return new ApiErrorResponse('Invalid request body. Expected json', null, [], Response::HTTP_BAD_REQUEST);
        }

        return new ApiErrorResponse('Server error', null, [], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

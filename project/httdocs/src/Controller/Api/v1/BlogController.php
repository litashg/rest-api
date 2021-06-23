<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiResponse;
use App\Controller\ApiController;
use App\DTO\BlogInputDTO;
use App\DTO\BlogOutputDTO;
use App\Service\BlogService;
use App\Transformer\BlogTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends ApiController
{
    CONST LIMIT = 6;
    CONST OFFSET = 0;

    public function getListAction(
        Request $request,
        BlogService $blogService,
        BlogTransformer $blogTransformer
    ): ApiResponse {
        $limit = (integer) $request->get('limit', self::LIMIT);
        $offset = (integer) $request->get('offset', self::OFFSET);

        $blogRecords = $blogService->findBy($limit, $offset);

        $blogOutputDTO = $blogTransformer->transformCollection($blogRecords, BlogOutputDTO::class);

        return new ApiResponse([
            'data' => $blogOutputDTO
        ], Response::HTTP_OK);
    }

    public function getOneAction(
        int $id,
        BlogService $blogService,
        BlogTransformer $blogTransformer
    ): ApiResponse {
        $blogEntity = $blogService->get($id);
        $blogOutputDTO = $blogTransformer->transform($blogEntity, BlogOutputDTO::class);
        return new ApiResponse([
            'data' => $blogOutputDTO
        ], Response::HTTP_OK);
    }

    public function createAction(
        Request $request,
        BlogService $blogService,
        BlogTransformer $blogTransformer
    ): ApiResponse {
        $inputDTO = $this->requestBodyConverter($request->getContent(), BlogInputDTO::class);
        $blogEntity = $blogService->create($inputDTO);

        $blogOutputDTO = $blogTransformer->transform($blogEntity, BlogOutputDTO::class);

        return new ApiResponse($blogOutputDTO, Response::HTTP_CREATED);
    }

    public function updateAction(
        int $id,
        Request $request,
        BlogService $blogService,
        BlogTransformer $blogTransformer
    ): ApiResponse {
        $inputDTO = $this->requestBodyConverter($request->getContent(), BlogInputDTO::class);
        $blogEntity = $blogService->update($id, $inputDTO);
        $blogOutputDTO = $blogTransformer->transform($blogEntity, BlogOutputDTO::class);
        return new ApiResponse($blogOutputDTO, Response::HTTP_OK);
    }

    public function deleteAction(
        int $id,
        BlogService $blogService
    ): ApiResponse {
        $blogService->delete($id);
        return new ApiResponse([], Response::HTTP_OK);
    }
}
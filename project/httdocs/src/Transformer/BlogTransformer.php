<?php

declare(strict_types=1);

namespace App\Transformer;

use App\DTO\BlogOutputDTO;
use App\Entity\Blog;
use App\Entity\EntityInterface;

class BlogTransformer implements DataTransformerInterface
{
    /**
     * @param Blog $dataObject
     * @param string $dto
     * @return array
     */
    public function transform(EntityInterface $dataObject, string $dto): array
    {
        /**
         * @param BlogOutputDTO $dto
         */
        $outputDto = new $dto(
            $dataObject->getEmail(),
            $dataObject->getName(),
            $dataObject->getText(),
            $dataObject->getStatus(),
            $dataObject->getCreatedAt(),
            $dataObject->getUpdatedAt()
        );

        return $outputDto->toArray();
    }

    /**
     * @param array<Blog> $dataList
     * @param string $dto
     * @return array
     */
    public function transformCollection(array $dataList, string $dto): array
    {
        $result = [];
        /**
         * @param BlogOutputDTO $dto
         * @param Blog $item
         */
        foreach ($dataList as $item) {
            $result[] = $this->transform($item, $dto);
        }

        return $result;
    }
}
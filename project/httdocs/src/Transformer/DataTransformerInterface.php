<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\EntityInterface;

interface DataTransformerInterface {
    public function transform(EntityInterface $dataObject, string $dto): array;
    public function transformCollection(array $dataList, string $dto): array;
}
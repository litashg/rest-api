<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\DTOInterface;
use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;

class BlogService {
    private EntityManagerInterface $entityManager;
    private BlogRepository $blogRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        BlogRepository $blogRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->blogRepository = $blogRepository;
    }

    public function create(DTOInterface $entityDTO): Blog
    {
        $blog = new Blog($entityDTO->getText(), $entityDTO->getEmail(), $entityDTO->getName());

        $this->entityManager->persist($blog);
        $this->entityManager->flush();

        return $blog;
    }

    public function update(int $id, DTOInterface $entityDTO): Blog
    {
        $blog = $this->get($id);

        $blog->setText($entityDTO->getText());
        $blog->setEmail($entityDTO->getEmail());
        $blog->setName($entityDTO->getName());

        $this->entityManager->persist($blog);
        $this->entityManager->flush();

        return $blog;
    }

    public function get(int $id): ?Blog
    {
        $blog =  $this->blogRepository->findOneBy([
            'id' => $id
        ]);

        if (!$blog) {
            throw new \InvalidArgumentException(sprintf(
                'Blog entity `%s` not exist. Please check your id',
                $id
            ));
        }

        return $blog;
    }

    public function findBy(int $limit, int $offset): array
    {
        return $this->blogRepository->findBy([], ['createdAt' => 'DESC'], $limit, $offset);
    }

    public function delete(int $id): void
    {
        $blog = $this->get($id);
        $this->entityManager->remove($blog);
        $this->entityManager->flush();
    }
}
<?php

declare(strict_types=1);

namespace App\DTO;

class BlogOutputDTO implements DTOInterface
{
    private string $email;
    private string $name;
    private string $text;
    private int $status;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(
        string $email,
        string $name,
        string $text,
        int $status,
        \DateTime $createdAt,
        \DateTime $updatedAt
    ) {
        $this->email = $email;
        $this->name = $name;
        $this->text = $text;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->getEmail(),
            'name' => $this->getName(),
            'text' => $this->getText(),
            'status' => $this->getStatus(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
        ];
    }
}
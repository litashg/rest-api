<?php

declare(strict_types=1);

namespace App\Entity;

use App\Constant\Blog\BlogStatus;
use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Blog implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     */
    private string $text;

    /**
     * @ORM\Column(type="text")
     */
    private string $name;

    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\Column(type="integer")
     */
    private int $status = BlogStatus::PENDING;

    /**
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private ?\DateTime $createdAt = null;

    /**
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private ?\DateTime $updatedAt = null;

    public function __construct(
        string $text,
        string $name,
        string $email
    ) {
        $this->text = $text;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}

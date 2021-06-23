<?php

declare(strict_types=1);

namespace App\DTO;

class BlogInputDTO implements DTOInterface
{
    private string $email;
    private string $name;
    private string $text;

    public function __construct(
        string $email,
        string $name,
        string $text
    ) {
        $this->email = $email;
        $this->name = $name;
        $this->text = $text;
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

    public function toArray(): array
    {
        return [
            'email' => $this->getEmail(),
            'name' => $this->getName(),
            'text' => $this->getText(),
        ];
    }
}
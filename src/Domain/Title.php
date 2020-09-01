<?php

declare(strict_types=1);

namespace App\Domain;

final class Title
{
    private ?string $title;

    private function __construct(?string $title)
    {
        $this->title = $title;
    }

    public static function fromString(?string $title): Title
    {
        return new Title($title);
    }

    public function asString(): string
    {
        return $this->title ?? '';
    }
}
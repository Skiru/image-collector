<?php

declare(strict_types=1);

namespace App\Domain;

final class Alt
{
    private ?string $alt;

    private function __construct(?string $alt)
    {
        $this->alt = $alt;
    }

    public static function fromString(?string $name): Alt
    {
        return new Alt($name);
    }

    public function asString(): string
    {
        return $this->alt ?? '';
    }
}
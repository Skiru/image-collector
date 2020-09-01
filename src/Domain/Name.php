<?php

declare(strict_types=1);

namespace App\Domain;

final class Name
{
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $name): Name
    {
        return new Name($name);
    }

    public function asString(): string
    {
        return $this->name;
    }

}
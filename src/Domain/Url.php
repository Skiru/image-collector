<?php

declare(strict_types=1);

namespace App\Domain;

final class Url
{
    private string $url;

    private function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function fromString(string $url): Url
    {
        return new Url($url);
    }

    public function asString(): string
    {
        return $this->url;
    }

    public function equals(Url $url): bool
    {
        return $this->url === $url->asString();
    }
}
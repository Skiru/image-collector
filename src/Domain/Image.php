<?php

declare(strict_types=1);

namespace App\Domain;

final class Image
{
    private Url $url;
    private Alt $alt;
    private Title $title;
    private Name $name;

    public function __construct(Url $url, Alt $alt, Title $title, Name $name)
    {
        $this->url = $url;
        $this->alt = $alt;
        $this->title = $title;
        $this->name = $name;
    }

    public static function fromParameters(Url $url, Alt $alt, Title $title, Name $name): Image
    {
        return new Image($url, $alt, $title, $name);
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getAlt(): Alt
    {
        return $this->alt;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}

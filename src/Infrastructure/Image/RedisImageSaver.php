<?php

declare(strict_types=1);

namespace App\Infrastructure\Image;

use App\Domain\Image;
use App\Domain\Service\ImageSaverInterface;
use Predis\Client;

final class RedisImageSaver implements ImageSaverInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function save(Image $image): void
    {
        $this->client->set($image->getUrl()->asString(), $image->getName()->asString());
    }

    public function exists(Image $image): bool
    {
        return 1 === $this->client->exists($image->getUrl()->asString());
    }
}
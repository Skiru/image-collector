<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Image;

interface ImageSaverInterface
{
    public function save(Image $image): void;
    public function exists(Image $image): bool;
}

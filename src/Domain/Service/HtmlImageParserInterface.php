<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Image;
use App\Infrastructure\InfrastructureException;

interface HtmlImageParserInterface
{
    /**
     * @return Image[]
     * @throws InfrastructureException
     */
    public function findImages(string $url): array;
}
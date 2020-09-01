<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\DomainException;
use App\Domain\Image;
use App\Infrastructure\InfrastructureException;

final class ImageDownloader
{
    private const IMAGE_LIMIT = 3;

    private ImageSaverInterface $imageSaver;
    private string $websiteUrl;
    private string $imagesPath;
    private HtmlImageParserInterface $imageParser;

    public function __construct(
        ImageSaverInterface $imageSaver,
        string $websiteUrl,
        string $imagesPath,
        HtmlImageParserInterface $imageParser
    ) {
        $this->imageSaver = $imageSaver;
        $this->websiteUrl = $websiteUrl;
        $this->imagesPath = $imagesPath;
        $this->imageParser = $imageParser;
    }

    /**
     * @throws DomainException
     * @throws InfrastructureException
     */
    public function download(): void
    {
        $images = $this->pickImages(
            $this->imageParser->findImages($this->websiteUrl),
            ImageDownloader::IMAGE_LIMIT
        );

        foreach ($images as $image) {
            $this->save($image);
        }
    }

    /**
     * @param Image[] $images
     *
     * @return Image[]
     *
     * @throws DomainException
     */
    private function pickImages(array $images, int $limit): array
    {
        $pickedImages = [];
        foreach ($images as $image) {
            if (!$this->imageSaver->exists($image)) {
                $pickedImages[] = $image;
                if ($limit === count($pickedImages)) {
                    return $pickedImages;
                }
            }
        }

        if ($limit > count($pickedImages)) {
            throw new DomainException('There\'s not enough unique images on the site!');
        }

        return $pickedImages;
    }

    /**
     * @throws DomainException
     */
    private function save(Image $image): void
    {
        $file = file_get_contents($this->websiteUrl . $image->getUrl()->asString());
        if (false === $file) {
            throw new DomainException('Could not get a content of the image!');
        }

        $downloadedFile = file_put_contents(
            sprintf('%s/%s', $this->imagesPath, $image->getName()->asString()),
            $file
        );

        if (false === $downloadedFile) {
            throw new DomainException('Could not save the image to the file!');
        }

        $this->imageSaver->save($image);
    }
}

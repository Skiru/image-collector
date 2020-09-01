<?php

declare(strict_types=1);

namespace App\Infrastructure\HtmlParser;

use App\Domain\Alt;
use App\Domain\Image;
use App\Domain\Name;
use App\Domain\Service\HtmlImageParserInterface;
use App\Domain\Title;
use App\Domain\Url;
use App\Infrastructure\InfrastructureException;
use DOMDocument;

final class DomDocumentHtmlParser implements HtmlImageParserInterface
{
    private const IMG_TAG = 'img';
    private const SRC_TAG = 'src';
    private const ALT_TAG = 'alt';
    private const TITLE_TAG = 'title';

    /**
     * @throws InfrastructureException
     */
    public function findImages(string $url): array
    {
        $document = new DOMDocument();
        $images = [];
        $htmlString = file_get_contents($url);
        if (false === $htmlString) {
            throw new InfrastructureException('Could not get the page!');
        }

        $html = $document->loadHTML($htmlString);
        if (false === $html) {
            throw new InfrastructureException('Could not get a HTML of the page!');
        }

        $imageTags = $document->getElementsByTagName(DomDocumentHtmlParser::IMG_TAG);

        foreach ($imageTags as $imageTag) {
            $url = $imageTag->getAttribute(DomDocumentHtmlParser::SRC_TAG);

            $images[] = Image::fromParameters(
                Url::fromString($url),
                Alt::fromString($imageTag->getAttribute(DomDocumentHtmlParser::ALT_TAG)),
                Title::fromString($imageTag->getAttribute(DomDocumentHtmlParser::TITLE_TAG)),
                Name::fromString($this->getImageNameFromUrl($url))
            );
        }

        return $images;
    }

    private function getImageNameFromUrl(string $url): string
    {
        return pathinfo($url, PATHINFO_BASENAME);
    }
}
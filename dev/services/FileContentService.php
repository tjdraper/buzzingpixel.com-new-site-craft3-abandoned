<?php

namespace dev\services;

use Hyn\Frontmatter\Parser;
use dev\models\ListingsModel;
use dev\models\FileContentModel;
use dev\models\ListingMetaModel;

/**
 * Class FileContentService
 */
class FileContentService
{
    /** @var string $config */
    private $contentPath;

    /** @var Parser $parser */
    private $parser;

    /** @var ListingMetaModel $listingMetaModel */
    private $listingMetaModel;

    /** @var ListingsModel $listingsModel */
    private $listingsModel;

    /**
     * FileContentService constructor
     * @param string $contentPath
     * @param Parser $parser
     * @param ListingMetaModel $listingMetaModel
     */
    public function __construct(
        string $contentPath,
        Parser $parser,
        ListingMetaModel $listingMetaModel,
        ListingsModel $listingsModel
    ) {
        $this->contentPath = $contentPath;
        $this->parser = $parser;
        $this->listingMetaModel = $listingMetaModel;
        $this->listingsModel = $listingsModel;
    }

    /**
     * Gets page content from directory
     * @param string $directory
     * @return FileContentModel
     * @throws \Exception
     */
    public function getContentFromDir(string $directory): FileContentModel
    {
        return $this->getContentFromDirInner(
            "{$this->contentPath}/{$directory}"
        );
    }

    /**
     * @param string $fullPath
     * @return FileContentModel;
     * @throws \Exception
     */
    private function getContentFromDirInner(string $fullPath): FileContentModel
    {
        $dirIterator = new \DirectoryIterator($fullPath);

        $model = new FileContentModel();

        foreach ($dirIterator as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }

            $fileName = $fileInfo->getBasename('.md');

            if (strtolower($fileName) === 'index') {
                $model->contentFile = $fileInfo->getPathname();
                continue;
            }

            $fileName = explode('-', $fileName);
            if (\count($fileName) > 1 && is_numeric($fileName[0])) {
                unset($fileName[0]);
            }
            $fileName = implode('-', $fileName);

            if ($fileInfo->isDir()) {
                $model->addChildModel(
                    $this->getContentFromDirInner(
                        $fileInfo->getPathname()
                    ),
                    $fileName
                );
                continue;
            }

            $model->addFile(
                $fileInfo->getPathname(),
                $fileName
            );
        }

        return $model;
    }

    /**
     * Gets listings from directory
     * @param string $dir
     * @return ListingsModel
     * @throws \Exception
     */
    public function getListingsFromDirectory(string $dir): ListingsModel
    {
        $fullPath = "{$this->contentPath}/{$dir}";

        $listings = [];

        $dirIterator = new \DirectoryIterator($fullPath);

        foreach ($dirIterator as $fileInfo) {
            $dirPath = $fileInfo->getPathname();
            $fullFilePath = "{$dirPath}/index.md";

            if ($fileInfo->isDot() || ! file_exists($fullFilePath)) {
                continue;
            }

            $parsed = $this->parser->parse(file_get_contents($fullFilePath));

            $metaModel = clone $this->listingMetaModel;

            $metaModel->setProperty('fullDirectoryPath', $dirPath);
            $metaModel->setProperty('markdown', $parsed['markdown']);
            $metaModel->setProperty('meta', $parsed['meta']);
            $metaModel->setProperty('html', $parsed['html']);
            $metaModel->setProperty('title', $parsed['meta']['title'] ?? '');
            $metaModel->setProperty('slug', $parsed['meta']['slug'] ?? '');
            $metaModel->setProperty('dateString', $parsed['meta']['date'] ?? '');
            $metaModel->setProperty('date', new \DateTime($parsed['meta']['date'] ?? ''));

            $listings["{$metaModel->date->getTimestamp()}-{$metaModel->slug}"] = $metaModel;
        }

        ksort($listings);
        $listings = array_reverse($listings);

        $returnListings = [];

        foreach ($listings as $listing) {
            $returnListings[$listing->slug] = $listing;
        }

        $meta = [];

        $metaPath = "{$fullPath}/index.md";

        if (file_exists($metaPath)) {
            $meta = $this->parser->parse(file_get_contents($metaPath));
        }

        $listingsModel = clone $this->listingsModel;
        $listingsModel->setProperty('listings', $returnListings);
        $listingsModel->setProperty('meta', $meta);

        return $listingsModel;
    }

    /**
     * Gets entry content by slug
     * @param string $slug
     * @param string $dir
     * @return null|ListingMetaModel
     * @throws \Exception
     */
    public function getEntryContentBySlug(string $slug, string $dir)
    {
        $listingsModel = $this->getListingsFromDirectory($dir);

        if (! isset($listingsModel->listings[$slug])) {
            return null;
        }

        $model = $listingsModel->listings[$slug];

        $model->contentModel = $this->getContentFromDirInner(
            $model->fullDirectoryPath
        );

        return $model;
    }
}

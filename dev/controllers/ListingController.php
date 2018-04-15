<?php

namespace dev\controllers;

use Craft;
use dev\Module;
use dev\services\PaginationGeneratorService;
use yii\web\Response;
use yii\web\HttpException;

/**
 * Class PagesController
 */
class ListingController extends BaseController
{
    /** @var int $pageLimit */
    private $pageLimit = 12;

    /**
     * Displays the news index (with pagination)
     * @param int $pageNum
     * @return Response
     * @throws \Exception
     */
    public function actionNews(int $pageNum = null): Response
    {
        return $this->parseListing($pageNum, 'News');
    }

    /**
     * Displays news permalink pages
     * @param string $slug
     * @return Response
     * @throws \Exception
     */
    public function actionNewsPermalink(string $slug): Response
    {
        return $this->parseListingPermalink($slug, 'News');
    }

    /**
     * Parses the display of a listing page (with pagination)
     * @param int|null $pageNum
     * @param string $directory
     * @return Response
     * @throws \Exception
     */
    private function parseListing($pageNum, string $directory): Response
    {
        // If the incoming page number is 1, it means we have a `page/1` in the
        // URL, which is always invalid. Page one should not have a pagiantion
        // indicator at all
        if ($pageNum === 1) {
            throw new HttpException(404);
        }

        $listingsModel = Module::fileContentService()->getListingsFromDirectory(
            $directory
        );

        $pageNum = $pageNum ?: 1;
        $limit = $this->pageLimit;
        $entriesTotal = \count($listingsModel->listings);
        $offset = ($limit * $pageNum) - $limit;
        $maxPages = (int) ceil($entriesTotal / $limit);

        if ($pageNum > $maxPages) {
            throw new HttpException(404);
        }

        $entries = \array_slice($listingsModel->listings, $offset, $limit);

        $contentMeta = $listingsModel->meta['meta'];
        $header = $listingsModel->meta;

        $metaTitle = $contentMeta['metaTitle'] ?? $contentMeta['title'] ?? null;
        $metaDescription = $contentMeta['metaDescription'] ??
            $contentMeta['description'] ??
            null;

        $segmentsArray = Craft::$app->getRequest()->getSegments();

        if ($pageNum > 1) {
            $metaTitle .= " | Page {$pageNum}";
            array_pop($segmentsArray);
            array_pop($segmentsArray);
        }

        $listingBase = '/' . implode('/', $segmentsArray);

        $pagination = PaginationGeneratorService::getPagination([
            'currentPage' => $pageNum,
            'perPage' => $limit,
            'totalResults' => $entriesTotal,
            'base' => $listingBase,
        ]);

        $breadcrumbs = [];

        if ($pageNum > 1) {
            $breadcrumbs = [
                [
                    'link' => $listingBase,
                    'content' => 'News',
                ],
                [
                    'link' => false,
                    'content' => "Page {$pageNum}",
                ],
            ];
        }

        return $this->renderTemplate('_core/EntryListing.twig', compact(
            'pageNum',
            'limit',
            'entriesTotal',
            'offset',
            'maxPages',
            'entries',
            'contentMeta',
            'metaTitle',
            'metaDescription',
            'header',
            'listingBase',
            'pagination',
            'breadcrumbs'
        ));
    }

    /**
     * Displays a listing permalink page
     * @param string $slug
     * @param string $dir
     * @return Response
     * @throws \Exception
     */
    private function parseListingPermalink(string $slug, string $dir): Response
    {
        $listingMetaModel = Module::fileContentService()->getEntryContentBySlug(
            $slug,
            $dir
        );

        if (! $listingMetaModel) {
            throw new HttpException(404);
        }

        $contentModel = $listingMetaModel->contentModel;
        $content = $contentModel->getContent();
        $contentMeta = $content['meta'];

        $metaTitle = $contentMeta['metaTitle'] ?? $contentMeta['title'] ?? null;
        $metaDescription = $contentMeta['metaDescription'] ??
            $contentMeta['description'] ??
            null;

        $header = $contentModel->getVarsAtIndex('Header');

        if (! isset($header['meta']['heading'])) {
            $header['meta']['heading'] = $contentMeta['title'];
        }

        $header['meta']['subHeading'] = $listingMetaModel->date->format(
            'l, F jS, Y'
        );

        $contentBlocks = [];

        $contentBlocksModel = $contentModel->getChildAtIndex('ContentBlocks');

        if ($contentBlocksModel) {
            $contentBlocks = $contentBlocksModel->getVars();
        }

        if (! $contentBlocks) {
            $contentBlocks[] = [
                'meta' => [
                    'blockType' => 'standard',
                ],
                'html' => $content['html'],
            ];
        }

        $segmentsArray = Craft::$app->getRequest()->getSegments();
        array_pop($segmentsArray);
        $listingBase = '/' . implode('/', $segmentsArray);

        $breadcrumbs = [
            [
                'link' => $listingBase,
                'content' => 'News',
            ],
        ];

        $page = 1;
        $counter = 1;

        $listingsModel = Module::fileContentService()->getListingsFromDirectory(
            $dir
        );

        foreach (array_keys($listingsModel->listings) as $listingSlug) {
            if ($counter > $this->pageLimit) {
                $page++;
                $counter = 1;
            }

            if ($slug === $listingSlug) {
                break;
            }

            $counter++;
        }

        if ($page > 1) {
            $breadcrumbs[] = [
                'link' => "{$listingBase}/page/{$page}",
                'content' => "Page {$page}",
            ];
        }

        $breadcrumbs[] = [
            'link' => false,
            'content' => 'Viewing Entry',
        ];

        $shareImage = $contentMeta['shareImage'] ?? null;

        return $this->renderTemplate('_core/PageStandard.twig', compact(
            'contentModel',
            'content',
            'contentMeta',
            'metaTitle',
            'metaDescription',
            'header',
            'contentBlocks',
            'breadcrumbs',
            'shareImage'
        ));
    }
}

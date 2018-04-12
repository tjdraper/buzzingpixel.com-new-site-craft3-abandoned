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
        $limit = 12;
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
            'pagination'
        ));
    }
}

<?php

namespace dev\controllers;

use Craft;
use dev\Module;
use yii\web\Response;

/**
 * Class DocsController
 */
abstract class DocsController extends BaseController
{
    /**
     * Parses a docs page
     * @param string $directory
     * @param array $switcher
     * @param string $backLink
     * @param string $childIndex
     * @return Response
     * @throws \Exception
     */
    protected function parsePage(
        string $directory,
        array $switcher = [],
        string $backLink = '/',
        string $childIndex = ''
    ): Response {
        $contentModel = Module::fileContentService()->getContentFromDir(
            $directory
        );

        $content = $contentModel->getContent();
        $contentMeta = $content['meta'];

        $nav = $contentMeta['Nav'] ?? [];

        $fullUrlPath = '/' . ltrim(Craft::$app->getRequest()->fullPath, '/');

        $pageContentModel = $contentModel->getChildAtIndex($childIndex);

        if (! $pageContentModel) {
            throw new \HttpException(404);
        }

        $pageContent = $pageContentModel->getContent();
        $pageContentMeta = $pageContent['meta'];

        $metaTitle = $pageContentMeta['metaTitle'] ??
            $pageContentMeta['title'] ??
            null;
        $metaDescription = $pageContentMeta['metaDescription'] ??
            $pageContentMeta['description'] ??
            null;

        if (! empty($contentMeta['title'])) {
            $metaTitle .= $metaTitle ? ' | ' : '';
            $metaTitle .= $contentMeta['title'];
        }

        $pageTitle = $pageContentMeta['title'] ?? '';
        $pageSections = $pageContentModel->getVars();

        return $this->renderTemplate('_core/PageDocs.twig', compact(
            'switcher',
            'backLink',
            'nav',
            'fullUrlPath',
            'metaTitle',
            'metaDescription',
            'pageContentModel',
            'pageTitle',
            'pageSections'
        ));
    }
}

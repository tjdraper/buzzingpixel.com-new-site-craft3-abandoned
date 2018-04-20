<?php

namespace dev\controllers;

use Craft;
use dev\Module;
use yii\web\Response;

/**
 * Class DocsController
 */
class DocsController extends BaseController
{
    /** @var array $anselSwitcher */
    private $anselSwitcher = [
        1 => [
            'link' => '/software/ansel-craft/docs/v1',
            'text' => 'Ansel (Craft) 1.x (legacy)',
            'isActive' => false,
        ],
        2 => [
            'link' => '/software/ansel-craft/docs',
            'text' => 'Ansel (Craft) 2.x (current)',
            'isActive' => false,
        ],
    ];

    /**
     * Displays the Ansel Craft docs page
     * @return Response
     * @throws \Exception
     */
    public function actionAnselCraftDocs(): Response
    {
        $this->anselSwitcher[2]['isActive'] = true;
        return $this->parsePage(
            'AnselCraft2Docs',
            $this->anselSwitcher,
            '/software/ansel-craft',
            'GettingStarted'
        );
    }

    /**
     * Parses a docs page
     * @param string $directory
     * @param array $switcher
     * @param string $backLink
     * @param string $childIndex
     * @return Response
     * @throws \Exception
     */
    public function parsePage(
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

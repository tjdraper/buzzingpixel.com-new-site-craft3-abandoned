<?php

namespace dev\controllers;

use dev\Module;
use yii\web\Response;

/**
 * Class PagesController
 */
class PagesController extends BaseController
{
    /**
     * Displays the Index page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        return $this->parsePage('Index');
    }

    /**
     * Displays Custom Websites page
     * @return Response
     * @throws \Exception
     */
    public function actionCustomWebsites(): Response
    {
        return $this->parsePage('CustomWebsites');
    }

    /**
     * Parses a page
     * @param string directory
     * @return Response
     * @throws \Exception
     */
    private function parsePage(string $directory): Response
    {
        $contentModel = Module::fileContentService()->getContentFromDir(
            $directory
        );

        $content = $contentModel->getContent();
        $contentMeta = $content['meta'];

        $metaTitle = $contentMeta['metaTitle'] ?? $contentMeta['title'] ?? null;
        $metaDescription = $contentMeta['metaDescription'] ??
            $contentMeta['description'] ??
            null;

        $header = $contentModel->getVarsAtIndex('Header');

        $contentBlocks = [];

        $contentBlocksModel = $contentModel->getChildAtIndex('ContentBlocks');

        if ($contentBlocksModel) {
            $contentBlocks = $contentBlocksModel->getVars();
        }

        return $this->renderTemplate('_core/PageStandard.twig', compact(
            'contentModel',
            'content',
            'contentMeta',
            'metaTitle',
            'metaDescription',
            'header',
            'contentBlocks'
        ));
    }
}

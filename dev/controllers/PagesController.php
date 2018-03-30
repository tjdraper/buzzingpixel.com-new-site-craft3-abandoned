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
     * Displays the index page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        return $this->parsePage('Index');
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

        return $this->renderTemplate('PageStandard.twig', compact(
            'contentModel',
            'content',
            'contentMeta',
            'metaTitle'
        ));
    }
}
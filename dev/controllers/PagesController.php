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
     * Displays Custom Add-ons page
     * @return Response
     * @throws \Exception
     */
    public function actionCustomAddons(): Response
    {
        return $this->parsePage('CustomAddons');
    }

    /**
     * Displays Hosting page
     * @return Response
     * @throws \Exception
     */
    public function actionHosting(): Response
    {
        return $this->parsePage('Hosting');
    }

    /**
     * Displays Portfolio page
     * @return Response
     * @throws \Exception
     */
    public function actionPortfolio(): Response
    {
        return $this->parsePage('Portfolio');
    }

    /**
     * Displays the contact page
     * @return Response
     * @throws \Exception
     */
    public function actionContact(): Response
    {
        return $this->parsePage('Contact');
    }

    /**
     * Displays contact thanks page
     * @return Response
     * @throws \Exception
     */
    public function actionContactThanks(): Response
    {
        return $this->parsePage('ContactThanks');
    }

    /**
     * Displays Ansel for Craft page
     * @return Response
     * @throws \Exception
     */
    public function actionAnselCraft(): Response
    {
        return $this->parsePage('AnselCraft');
    }

    /**
     * Displays Ansel for EE page
     * @return Response
     * @throws \Exception
     */
    public function actionAnselEe(): Response
    {
        return $this->parsePage('AnselEE');
    }

    /**
     * Displays Treasury page
     * @return Response
     * @throws \Exception
     */
    public function actionTreasury(): Response
    {
        return $this->parsePage('Treasury');
    }

    /**
     * Displays Ansel + Treasury page
     * @return Response
     * @throws \Exception
     */
    public function actionAnselTreasuryEe(): Response
    {
        return $this->parsePage('AnselTreasury');
    }

    /**
     * Displays Construct page
     * @return Response
     * @throws \Exception
     */
    public function actionConstruct(): Response
    {
        return $this->parsePage('Construct');
    }

    /**
     * Displays Construct page
     * @return Response
     * @throws \Exception
     */
    public function actionCategoryConstruct(): Response
    {
        return $this->parsePage('CategoryConstruct');
    }

    /**
     * Displays Construct page
     * @return Response
     * @throws \Exception
     */
    public function actionCollective(): Response
    {
        return $this->parsePage('Collective');
    }

    /**
     * Displays Construct page
     * @return Response
     * @throws \Exception
     */
    public function actionFreeSoftware(): Response
    {
        return $this->parsePage('FreeSoftware');
    }

    /**
     * Displays Cookie Policy page
     * @return Response
     * @throws \Exception
     */
    public function actionCookies(): Response
    {
        return $this->parsePage('Cookies');
    }

    /**
     * Display registration intermediate page
     * @return Response
     * @throws \Exception
     */
    public function actionAccountRegisterIntermediate(): Response
    {
        return $this->parsePage('AccountRegistrationIntermediate');
    }

    /**
     * Display account activation error page
     * @return Response
     * @throws \Exception
     */
    public function actionAccountActivationError(): Response
    {
        return $this->parsePage('AccountActivationError');
    }


    /**************************************************************************/
    /* Common parsing for Pages */
    /**************************************************************************/

    /**
     * Parses a page
     * @param string $directory
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

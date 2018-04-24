<?php

namespace dev\controllers;

use Craft;
use yii\web\Response;

/**
 * Class DocsCategoryConstructController
 */
class DocsCategoryConstructController extends DocsController
{
    /** @var array $switcher */
    private $switcher = [];


    /**************************************************************************/
    /* Category Construct 2.x */
    /**************************************************************************/

    /**
     * Displays the Category Construct docs index page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        return $this->parsePageCategoryConstruct2('GettingStarted');
    }

    /**
     * Displays the Category Construct docs index page
     * @return Response
     * @throws \Exception
     */
    public function actionTemplating(): Response
    {
        return $this->parsePageCategoryConstruct2('Templating');
    }


    /**************************************************************************/
    /* Common parsing for Construct Docs */
    /**************************************************************************/

    /**
     * @param string $childIndex
     * @return Response
     * @throws \Exception
     */
    private function parsePageCategoryConstruct2(string $childIndex): Response
    {
        return $this->parsePage(
            'CategoryConstruct2Docs',
            'Category Construct Docs',
            $this->switcher,
            '/software/category-construct',
            $childIndex
        );
    }
}

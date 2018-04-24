<?php

namespace dev\controllers;

use Craft;
use yii\web\Response;

/**
 * Class DocsCollectiveController
 */
class DocsCollectiveController extends DocsController
{
    /** @var array $switcher */
    private $switcher = [];


    /**************************************************************************/
    /* Collective 2.x */
    /**************************************************************************/

    /**
     * Displays the Collective docs index page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        return $this->parsePageCollective2('GettingStarted');
    }


    /**************************************************************************/
    /* Common parsing for Collective */
    /**************************************************************************/

    /**
     * @param string $childIndex
     * @return Response
     * @throws \Exception
     */
    private function parsePageCollective2(string $childIndex): Response
    {
        return $this->parsePage(
            'Collective2Docs',
            'Collective Docs',
            $this->switcher,
            '/software/collective',
            $childIndex
        );
    }
}

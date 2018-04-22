<?php

namespace dev\controllers;

use yii\web\Response;

/**
 * Class DocsAnselEeController
 */
class DocsAnselEeController extends DocsController
{
    /** @var array $anselSwitcher */
    private $anselSwitcher = [];


    /**************************************************************************/
    /* Ansel 2.x */
    /**************************************************************************/

    /**
     * Displays the Ansel Craft docs index page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        return $this->parsePageAnselEE2('GettingStarted');
    }


    /**************************************************************************/
    /* Common parsing for Ansel EE Docs */
    /**************************************************************************/

    /**
     * @param string $childIndex
     * @return Response
     * @throws \Exception
     */
    private function parsePageAnselEE2(string $childIndex): Response
    {
        return $this->parsePage(
            'AnselEE2Docs',
            'Ansel 2.x Docs',
            $this->anselSwitcher,
            '/software/ansel-ee',
            $childIndex
        );
    }
}

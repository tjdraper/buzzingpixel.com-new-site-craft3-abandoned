<?php

namespace dev\controllers;

use yii\web\Response;

/**
 * Class DocsTreasuryController
 */
class DocsTreasuryController extends DocsController
{
    /** @var array $anselSwitcher */
    private $switcher = [];


    /**************************************************************************/
    /* Treasury 1.x */
    /**************************************************************************/

    /**
     * Displays the Treasury docs index page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        return $this->parsePageTreasury1('GettingStarted');
    }


    /**************************************************************************/
    /* Common parsing for Treasury Docs */
    /**************************************************************************/

    /**
     * @param string $childIndex
     * @return Response
     * @throws \Exception
     */
    private function parsePageTreasury1(string $childIndex): Response
    {
        return $this->parsePage(
            'Treasury1Docs',
            'Treasury Docs',
            $this->switcher,
            '/software/treasury',
            $childIndex
        );
    }
}

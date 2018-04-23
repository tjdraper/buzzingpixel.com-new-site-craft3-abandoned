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

    /**
     * Displays the Treasury docs Locations page
     * @return Response
     * @throws \Exception
     */
    public function actionLocations(): Response
    {
        return $this->parsePageTreasury1('Locations');
    }

    /**
     * Displays the Treasury docs Templating page
     * @return Response
     * @throws \Exception
     */
    public function actionTemplating(): Response
    {
        return $this->parsePageTreasury1('Templating');
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

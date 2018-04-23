<?php

namespace dev\controllers;

use yii\web\Response;

/**
 * Class DocsConstructController
 */
class DocsConstructController extends DocsController
{
    /** @var array $switcher */
    private $switcher = [];


    /**************************************************************************/
    /* Construct 2.x */
    /**************************************************************************/

    /**
     * Displays the Construct docs index page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        return $this->parsePageConstruct1('GettingStarted');
    }

    /**
     * Displays the Construct docs Control Panel page
     * @return Response
     * @throws \Exception
     */
    public function actionControlPanel(): Response
    {
        return $this->parsePageConstruct1('ControlPanel');
    }


    /**************************************************************************/
    /* Common parsing for Construct Docs */
    /**************************************************************************/

    /**
     * @param string $childIndex
     * @return Response
     * @throws \Exception
     */
    private function parsePageConstruct1(string $childIndex): Response
    {
        return $this->parsePage(
            'Construct2Docs',
            'Construct Docs',
            $this->switcher,
            '/software/construct',
            $childIndex
        );
    }
}

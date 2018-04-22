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
     * Displays the Ansel EE docs index page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        return $this->parsePageAnselEE2('GettingStarted');
    }

    /**
     * Displays the Ansel EE docs Field Type Settings page
     * @return Response
     * @throws \Exception
     */
    public function actionFieldTypeSettings(): Response
    {
        return $this->parsePageAnselEE2('FieldTypeSettings');
    }

    /**
     * Displays the Ansel EE docs Field Type Use page
     * @return Response
     * @throws \Exception
     */
    public function actionFieldTypeUse(): Response
    {
        return $this->parsePageAnselEE2('FieldTypeUse');
    }

    /**
     * Displays the Ansel EE docs Templating page
     * @return Response
     * @throws \Exception
     */
    public function actionTemplating(): Response
    {
        return $this->parsePageAnselEE2('Templating');
    }

    /**
     * Displays the Ansel Craft docs Videos page
     * @return Response
     * @throws \Exception
     */
    public function actionVideos(): Response
    {
        return $this->parsePageAnselEE2('Videos');
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

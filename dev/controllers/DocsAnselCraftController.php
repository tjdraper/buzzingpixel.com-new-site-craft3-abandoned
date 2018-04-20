<?php

namespace dev\controllers;

use yii\web\Response;

/**
 * Class DocsAnselCraftController
 */
class DocsAnselCraftController extends DocsController
{
    /** @var array $anselSwitcher */
    private $anselSwitcher = [
        2 => [
            'link' => '/software/ansel-craft/docs',
            'text' => 'Ansel (Craft) 2.x (current)',
            'isActive' => false,
        ],
        1 => [
            'link' => '/software/ansel-craft/docs/v1',
            'text' => 'Ansel (Craft) 1.x (legacy)',
            'isActive' => false,
        ],
    ];


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
        return $this->parsePageAnselCraft2('GettingStarted');
    }

    /**
     * Displays the Ansel Craft docs Field Type Settings page
     * @return Response
     * @throws \Exception
     */
    public function actionFieldTypeSettings(): Response
    {
        return $this->parsePageAnselCraft2('FieldTypeSettings');
    }

    /**
     * Displays the Ansel Craft docs Field Type Use page
     * @return Response
     * @throws \Exception
     */
    public function actionFieldTypeUse(): Response
    {
        return $this->parsePageAnselCraft2('FieldTypeUse');
    }

    /**
     * Displays the Ansel Craft docs Field Type Use page
     * @return Response
     * @throws \Exception
     */
    public function actionTemplating(): Response
    {
        return $this->parsePageAnselCraft2('Templating');
    }

    /**
     * Displays the Ansel Craft docs Field Type Use page
     * @return Response
     * @throws \Exception
     */
    public function actionVideos(): Response
    {
        return $this->parsePageAnselCraft2('Videos');
    }


    /**************************************************************************/
    /* Common parsing for Ansel Craft Docs */
    /**************************************************************************/

    /**
     * @param string $childIndex
     * @return Response
     * @throws \Exception
     */
    private function parsePageAnselCraft2(string $childIndex): Response
    {
        $this->anselSwitcher[2]['isActive'] = true;
        return $this->parsePage(
            'AnselCraft2Docs',
            $this->anselSwitcher,
            '/software/ansel-craft',
            $childIndex
        );
    }
}

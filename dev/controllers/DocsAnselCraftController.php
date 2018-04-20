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
        1 => [
            'link' => '/software/ansel-craft/docs/v1',
            'text' => 'Ansel (Craft) 1.x (legacy)',
            'isActive' => false,
        ],
        2 => [
            'link' => '/software/ansel-craft/docs',
            'text' => 'Ansel (Craft) 2.x (current)',
            'isActive' => false,
        ],
    ];

    /**
     * Displays the Ansel Craft docs index page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        $this->anselSwitcher[2]['isActive'] = true;
        return $this->parsePage(
            'AnselCraft2Docs',
            $this->anselSwitcher,
            '/software/ansel-craft',
            'GettingStarted'
        );
    }

    /**
     * Displays the Ansel Craft docs index page
     * @return Response
     * @throws \Exception
     */
    public function actionFieldTypeSettings(): Response
    {
        $this->anselSwitcher[2]['isActive'] = true;
        return $this->parsePage(
            'AnselCraft2Docs',
            $this->anselSwitcher,
            '/software/ansel-craft',
            'FieldTypeSettings'
        );
    }
}

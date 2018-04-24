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

    /**
     * Displays the Collective docs Control Panel page
     * @return Response
     * @throws \Exception
     */
    public function actionControlPanel(): Response
    {
        return $this->parsePageCollective2('ControlPanel');
    }

    /**
     * Displays the Collective docs Templating page
     * @return Response
     * @throws \Exception
     */
    public function actionTemplating(): Response
    {
        return $this->parsePageCollective2('Templating');
    }

    /**
     * Displays the Collective docs Extension Hook page
     * @return Response
     * @throws \Exception
     */
    public function actionExtensionHook(): Response
    {
        return $this->parsePageCollective2('ExtensionHook');
    }

    /**
     * Displays the Collective docs Changelog page
     * @return Response
     * @throws \Exception
     */
    public function actionChangelog(): Response
    {
        return $this->parseLocalChangelog(
            'Collective2Docs',
            'Collective Docs',
            $this->switcher,
            '/software/collective',
            'Collective Changelog',
            Craft::$app->getConfig()->general->projectPath . '/content/Collective2Docs/changelog.md'
        );
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

<?php

namespace dev\controllers;

use Craft;
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

    /**
     * Displays the Construct docs Field Types page
     * @return Response
     * @throws \Exception
     */
    public function actionFieldTypes(): Response
    {
        return $this->parsePageConstruct1('FieldTypes');
    }

    /**
     * Displays the Construct docs Routing page
     * @return Response
     * @throws \Exception
     */
    public function actionRouting(): Response
    {
        return $this->parsePageConstruct1('Routing');
    }

    /**
     * Displays the Construct docs Config Routing page
     * @return Response
     * @throws \Exception
     */
    public function actionConfigRouting(): Response
    {
        return $this->parsePageConstruct1('ConfigRouting');
    }

    /**
     * Displays the Construct docs Templating page
     * @return Response
     * @throws \Exception
     */
    public function actionTemplating(): Response
    {
        return $this->parsePageConstruct1('Templating');
    }

    /**
     * Displays the Construct docs Extension Hook page
     * @return Response
     * @throws \Exception
     */
    public function actionExtensionHook(): Response
    {
        return $this->parsePageConstruct1('ExtensionHook');
    }

    /**
     * Displays the Construct docs Videos page
     * @return Response
     * @throws \Exception
     */
    public function actionVideos(): Response
    {
        return $this->parsePageConstruct1('Videos');
    }

    /**
     * Displays the Construct docs Changelog page
     * @return Response
     * @throws \Exception
     */
    public function actionChangelog(): Response
    {
        return $this->parseLocalChangelog(
            'Construct2Docs',
            'Construct Docs',
            $this->switcher,
            '/software/construct',
            'Construct Changelog',
            Craft::$app->getConfig()->general->projectPath. '/content/Construct2Docs/changelog.md'
        );
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

<?php

namespace dev;

use Craft;
use dev\services\GlobalsService;
use yii\base\Event;
use craft\elements\Entry;
use dev\services\CacheService;
use yii\base\Module as ModuleBase;
use dev\services\FileContentService;
use dev\services\EntryRoutingService;
use craft\events\SetElementRouteEvent;
use dev\services\FileOperationsService;
use dev\twigextensions\FileTimeTwigExtension;
use craft\console\Application as ConsoleApplication;

/**
 * Custom module class for this project.
 *
 * This class will be available throughout the system via:
 * `Craft::$app->getModule('dev')`.
 *
 * Learn more about Yii module development in Yii's documentation:
 * http://www.yiiframework.com/doc-2.0/guide-structure-modules.html
 */
class Module extends ModuleBase
{
    /**
     * Initializes the module.
     * @throws \Exception
     */
    public function init()
    {
        $this->setUp();
        $this->registerTwigExtensions();
        $this->registerGlobals();
        $this->setEvents();

        // Add in our console commands
        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'dev\commands';
        }

        parent::init();
    }

    /**
     * Sets up the module
     * @throws \Exception
     */
    private function setUp()
    {
        Craft::setAlias('@dev', __DIR__);

        if (getenv('CLEAR_TEMPLATE_CACHE_ON_LOAD') === 'true') {
            (new CacheService())->clearTemplateCache();
        }
    }

    /**
     * Registers twig extensions
     */
    private function registerTwigExtensions()
    {
        $view = Craft::$app->view;
        $view->registerTwigExtension(new FileTimeTwigExtension());
    }

    private function registerGlobals()
    {
        static::globalsService()->registerGlobalsFromDir(
            \dirname(__DIR__) . '/content/Globals'
        );
    }

    /**
     * Sets events
     * @throws \Exception
     */
    private function setEvents()
    {
        Event::on(
            Entry::class,
            Entry::EVENT_SET_ROUTE,
            function (SetElementRouteEvent $eventModel) {
                $entryRoutingService = new EntryRoutingService();
                $entryRoutingService->entryControllerRouting($eventModel);
            }
        );
    }



    /**************************************************************************/
    /* Dependency injection */
    /**************************************************************************/

    /**
     * Gets the File Content Service
     * @return FileContentService
     */
    public static function fileContentService(): FileContentService
    {
        return new FileContentService(
            Craft::$app->getConfig()->getGeneral()->contentPath
        );
    }

    /**
     * Gets the File Operations Service
     * @return FileOperationsService
     */
    public static function fileOperationsService(): FileOperationsService
    {
        return new FileOperationsService(
            Craft::$app->getConfig()->general->basePath
        );
    }

    /**
     * Gets the Globals Service
     * @return GlobalsService
     */
    public static function globalsService(): GlobalsService
    {
        return new GlobalsService(Craft::$app->view->getTwig());
    }
}

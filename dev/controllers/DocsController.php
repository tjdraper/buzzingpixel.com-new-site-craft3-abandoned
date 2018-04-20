<?php

namespace dev\controllers;

use dev\Module;
use yii\web\Response;

/**
 * Class DocsController
 */
class DocsController extends BaseController
{
    /**
     * Displays the Ansel Craft docs page
     * @return Response
     * @throws \Exception
     */
    public function actionAnselCraftDocs(): Response
    {
        return $this->renderTemplate('_core/PageDocs.twig');
    }
}

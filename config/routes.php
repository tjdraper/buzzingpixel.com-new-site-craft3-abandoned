<?php
/**
 * Site URL Rules
 *
 * You can define custom site URL rules here, which Craft will check in addition
 * to any routes you’ve defined in Settings → Routes.
 *
 * See http://www.yiiframework.com/doc-2.0/guide-runtime-routing.html for more
 * info about URL rules.
 *
 * In addition to Yii’s supported syntaxes, Craft supports a shortcut syntax for
 * defining template routes:
 *
 *     'blog/archive/<year:\d{4}>' => ['template' => 'blog/_archive'],
 *
 * That example would match URIs such as `/blog/archive/2012`, and pass the
 * request along to the `blog/_archive` template, providing it a `year` variable
 * set to the value `2012`.
 */

return [

    /**************************************************************************/
    /* Pages routing */
    /**************************************************************************/

    /**
     * Index page
     * @see \dev\controllers\PagesController::actionIndex()
     */
    'GET /' => 'dev/pages/index',


    /**
     * Custom Websites page
     * @see \dev\controllers\PagesController::actionCustomWebsites()
     */
    'GET /work-with-me/custom-websites' => 'dev/pages/custom-websites',


    /**
     * Custom Add-ons page
     * @see \dev\controllers\PagesController::actionCustomAddons()
     */
    'GET /work-with-me/custom-add-ons' => 'dev/pages/custom-addons',

];

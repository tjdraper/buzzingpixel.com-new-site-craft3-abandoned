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

    // Index page
    /** @see \dev\controllers\PagesController::actionIndex() */
    'GET /' => 'dev/pages/index',

    // Custom Websites page
    /** @see \dev\controllers\PagesController::actionCustomWebsites() */
    'GET /work-with-me/custom-websites' => 'dev/pages/custom-websites',

    // Custom Add-ons page
    /** @see \dev\controllers\PagesController::actionCustomAddons() */
    'GET /work-with-me/custom-add-ons' => 'dev/pages/custom-addons',

    // Managed Hosting page
    /** @see \dev\controllers\PagesController::actionHosting() */
    'GET /work-with-me/hosting' => 'dev/pages/hosting',

    // Portfolio page
    /** @see \dev\controllers\PagesController::actionPortfolio() */
    'GET /work-with-me/portfolio' => 'dev/pages/portfolio',

    // Contact page
    /** @see \dev\controllers\PagesController::actionContact() */
    'GET /contact' => 'dev/pages/contact',
    'POST /contact' => 'dev/pages/contact',

    // Contact thank you page
    /** @see \dev\controllers\PagesController::actionContactThanks() */
    'GET /contact/thanks' => 'dev/pages/contact-thanks',

    // News page (paginated)
    /** @see \dev\controllers\ListingController::actionNews() */
    'GET /news' => 'dev/listing/news',
    'GET /news/page/<pageNum:\d+>' => 'dev/listing/news',

    // News permalink
    /** @see \dev\controllers\ListingController::actionNewsPermalink() */
    'GET /news/<slug:[^\/]+>' => 'dev/listing/news-permalink',

    // Ansel Craft Page
    /** @see \dev\controllers\PagesController::actionAnselCraft() */
    'GET /software/ansel-craft' => 'dev/pages/ansel-craft',

    // Ansel EE Page
    /** @see \dev\controllers\PagesController::actionAnselEe() */
    'GET /software/ansel-ee' => 'dev/pages/ansel-ee',





    /**************************************************************************/
    /* Documentation routing */
    /**************************************************************************/

    /**
     * Ansel Craft Docs Pages V2
     */

    /** @see \dev\controllers\DocsAnselCraftController::actionIndex() */
    'GET /software/ansel-craft/docs' => 'dev/docs-ansel-craft/index',

    /** @see \dev\controllers\DocsAnselCraftController::actionFieldTypeSettings() */
    'GET /software/ansel-craft/docs/field-type-settings' => 'dev/docs-ansel-craft/field-type-settings',

    /** @see \dev\controllers\DocsAnselCraftController::actionFieldTypeUse() */
    'GET /software/ansel-craft/docs/field-type-use' => 'dev/docs-ansel-craft/field-type-use',

    /** @see \dev\controllers\DocsAnselCraftController::actionTemplating() */
    'GET /software/ansel-craft/docs/templating' => 'dev/docs-ansel-craft/templating',

    /** @see \dev\controllers\DocsAnselCraftController::actionVideos() */
    'GET /software/ansel-craft/docs/videos' => 'dev/docs-ansel-craft/videos',

    /** @see \dev\controllers\DocsAnselCraftController::actionChangelog() */
    'GET /software/ansel-craft/docs/changelog' => 'dev/docs-ansel-craft/changelog',


    /**
     * Ansel Craft Docs Pages V1
     */

    /** @see \dev\controllers\DocsAnselCraftController::actionIndexV1() */
    'GET /software/ansel-craft/docs/v1' => 'dev/docs-ansel-craft/index-v1',

    /** @see \dev\controllers\DocsAnselCraftController::actionFieldTypeSettingsV1() */
    'GET /software/ansel-craft/docs/v1/field-type-settings' => 'dev/docs-ansel-craft/field-type-settings-v1',

    /** @see \dev\controllers\DocsAnselCraftController::actionFieldTypeUseV1() */
    'GET /software/ansel-craft/docs/v1/field-type-use' => 'dev/docs-ansel-craft/field-type-use-v1',

    /** @see \dev\controllers\DocsAnselCraftController::actionTemplatingV1() */
    'GET /software/ansel-craft/docs/v1/templating' => 'dev/docs-ansel-craft/templating-v1',

    /** @see \dev\controllers\DocsAnselCraftController::actionVideosV1() */
    'GET /software/ansel-craft/docs/v1/videos' => 'dev/docs-ansel-craft/videos-v1',


    /**
     * Ansel EE Docs Pages V2
     */

    /** @see \dev\controllers\DocsAnselEeController::actionIndex() */
    'GET /software/ansel-ee/docs' => 'dev/docs-ansel-ee/index',

    /** @see \dev\controllers\DocsAnselEeController::actionFieldTypeSettings() */
    'GET /software/ansel-ee/docs/field-type-settings' => 'dev/docs-ansel-ee/field-type-settings',

    /** @see \dev\controllers\DocsAnselEeController::actionFieldTypeUse() */
    'GET /software/ansel-ee/docs/field-type-use' => 'dev/docs-ansel-ee/field-type-use',

    /** @see \dev\controllers\DocsAnselEeController::actionTemplating() */
    'GET /software/ansel-ee/docs/templating' => 'dev/docs-ansel-ee/templating',





    /**************************************************************************/
    /* Cart routing */
    /**************************************************************************/

    // Display cart page
    /** @see \dev\controllers\PagesController::actionCart() */
    'GET /cart' => 'dev/pages/cart',

    // Get cart count
    /** @see \dev\controllers\PagesController::actionAjaxCount() */
    'GET /ajax/cart/count' => 'store/cart-content/ajax-count',

    // Add to cart action
    /** @see \modules\store\controllers\CartContentController::actionAdd() */
    'GET /cart/add/<productKey:([^\/]+)>' => 'store/cart-content/add',

];

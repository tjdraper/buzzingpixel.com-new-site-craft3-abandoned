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

    // Treasury Page
    /** @see \dev\controllers\PagesController::actionTreasury() */
    'GET /software/treasury' => 'dev/pages/treasury',

    // Ansel + Treasury Page
    /** @see \dev\controllers\PagesController::actionAnselTreasuryEe() */
    'GET /software/ansel-treasury-ee' => 'dev/pages/ansel-treasury-ee',

    // Construct Page
    /** @see \dev\controllers\PagesController::actionConstruct() */
    'GET /software/construct' => 'dev/pages/construct',

    // Category Construct Page
    /** @see \dev\controllers\PagesController::actionCategoryConstruct() */
    'GET /software/category-construct' => 'dev/pages/category-construct',

    // Collective Page
    /** @see \dev\controllers\PagesController::actionCollective() */
    'GET /software/collective' => 'dev/pages/collective',





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
     * Treasury Docs Pages
     */

    /** @see \dev\controllers\DocsTreasuryController::actionIndex() */
    'GET /software/treasury/docs' => 'dev/docs-treasury/index',

    /** @see \dev\controllers\DocsTreasuryController::actionLocations() */
    'GET /software/treasury/docs/locations' => 'dev/docs-treasury/locations',

    /** @see \dev\controllers\DocsTreasuryController::actionTemplating() */
    'GET /software/treasury/docs/templating' => 'dev/docs-treasury/templating',

    /** @see \dev\controllers\DocsTreasuryController::actionDevelopers() */
    'GET /software/treasury/docs/developers' => 'dev/docs-treasury/developers',

    /** @see \dev\controllers\DocsTreasuryController::actionChangelog() */
    'GET /software/treasury/docs/changelog' => 'dev/docs-treasury/changelog',


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

    /** @see \dev\controllers\DocsAnselEeController::actionVideos() */
    'GET /software/ansel-ee/docs/videos' => 'dev/docs-ansel-ee/videos',

    /** @see \dev\controllers\DocsAnselEeController::actionChangelog() */
    'GET /software/ansel-ee/docs/changelog' => 'dev/docs-ansel-ee/changelog',


    /**
     * Construct Docs Pages
     */

    /** @see \dev\controllers\DocsConstructController::actionIndex() */
    'GET /software/construct/docs' => 'dev/docs-construct/index',

    /** @see \dev\controllers\DocsConstructController::actionControlPanel() */
    'GET /software/construct/docs/control-panel' => 'dev/docs-construct/control-panel',

    /** @see \dev\controllers\DocsConstructController::actionFieldTypes() */
    'GET /software/construct/docs/field-types' => 'dev/docs-construct/field-types',

    /** @see \dev\controllers\DocsConstructController::actionRouting() */
    'GET /software/construct/docs/routing' => 'dev/docs-construct/routing',

    /** @see \dev\controllers\DocsConstructController::actionConfigRouting() */
    'GET /software/construct/docs/config-routing' => 'dev/docs-construct/config-routing',

    /** @see \dev\controllers\DocsConstructController::actionTemplating() */
    'GET /software/construct/docs/templating' => 'dev/docs-construct/templating',

    /** @see \dev\controllers\DocsConstructController::actionExtensionHook() */
    'GET /software/construct/docs/extension-hook' => 'dev/docs-construct/extension-hook',

    /** @see \dev\controllers\DocsConstructController::actionVideos() */
    'GET /software/construct/docs/videos' => 'dev/docs-construct/videos',

    /** @see \dev\controllers\DocsConstructController::actionChangelog() */
    'GET /software/construct/docs/changelog' => 'dev/docs-construct/changelog',


    /**
     * Category Construct Docs Pages
     */

    /** @see \dev\controllers\DocsCategoryConstructController::actionIndex() */
    'GET /software/category-construct/docs' => 'dev/docs-category-construct/index',

    /** @see \dev\controllers\DocsCategoryConstructController::actionTemplating() */
    'GET /software/category-construct/docs/templating' => 'dev/docs-category-construct/templating',

    /** @see \dev\controllers\DocsCategoryConstructController::actionChangelog() */
    'GET /software/category-construct/docs/changelog' => 'dev/docs-category-construct/changelog',


    /**
     * Collective Docs Pages
     */

    /** @see \dev\controllers\DocsCollectiveController::actionIndex() */
    'GET /software/collective/docs' => 'dev/docs-collective/index',

    /** @see \dev\controllers\DocsCollectiveController::actionControlPanel() */
    'GET /software/collective/docs/control-panel' => 'dev/docs-collective/control-panel',

    /** @see \dev\controllers\DocsCollectiveController::actionTemplating() */
    'GET /software/collective/docs/templating' => 'dev/docs-collective/templating',

    /** @see \dev\controllers\DocsCollectiveController::actionExtensionHook() */
    'GET /software/collective/docs/extension-hook' => 'dev/docs-collective/extension-hook',

    /** @see \dev\controllers\DocsCollectiveController::actionChangelog() */
    'GET /software/collective/docs/changelog' => 'dev/docs-collective/changelog',





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

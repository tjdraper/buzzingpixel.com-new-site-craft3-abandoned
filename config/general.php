<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

$projectPath = dirname(__DIR__, 1);

return [
    '*' => [
        'activateAccountSuccessPath' => 'account',
        'autoLoginAfterAccountActivation' => true,
        'allowUpdates' => false,
        'appId' => 'BuzzingPixelWebsite',
        'cacheDuration' => 0,
        'cacheMethod' => 'apc',
        'basePath' => "{$projectPath}/public",
        'contentPath' => "{$projectPath}/content",
        'cpTrigger' => 'cms',
        'devMode' => getenv('DEV_MODE') === 'true',
        'errorTemplatePrefix' => '_errors/',
        'generateTransformsBeforePageLoad' => true,
        'invalidUserTokenPath' => 'account/activation-error',
        'isSystemOn' => true,
        'loginPath' => 'account/login',
        'logoutPath' => 'account/logout',
        'maxUploadFileSize' => 512000000,
        'omitScriptNameInUrls' => true,
        // 'postCpLoginRedirect' => 'entries',
        'postLoginRedirect' => 'account',
        'postLogoutRedirect' => '',
        'projectPath' => $projectPath,
        'rememberedUserSessionDuration' => 'P100Y', // 100 years
        'securityKey' => getenv('SECURITY_KEY'),
        'sendPoweredByHeader' => false,
        'setPasswordPath' => 'account/setpassword',
        'setPasswordSuccessPath' => 'account',
        'siteName' => 'BuzzingPixel',
        'siteUrl' => getenv('SITE_URL'),
        'suppressTemplateErrors' => getenv('DEV_MODE') !== 'true',
        'timezone' => 'America/Chicago',
        'useEmailAsUsername' => true,
        'userSessionDuration' => false, // As long as browser stays open
        'staticAssetCacheTime' => '',
    ],
];

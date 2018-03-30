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
        'allowUpdates' => false,
        'projectPath' => $projectPath,
        'basePath' => "{$projectPath}/public",
        'contentPath' => "{$projectPath}/content",
        'cpTrigger' => 'cms',
        'defaultWeekStartDay' => 0,
        'devMode' => getenv('DEV_MODE') === 'true',
        'enableCsrfProtection' => true,
        'errorTemplatePrefix' => '_errors/',
        'generateTransformsBeforePageLoad' => true,
        'isSystemOn' => true,
        'maxUploadFileSize' => 512000000,
        'omitScriptNameInUrls' => true,
        'postCpLoginRedirect' => 'entries',
        'rememberedUserSessionDuration' => 631139040, // 20 years
        'securityKey' => getenv('SECURITY_KEY'),
        'sendPoweredByHeader' => false,
        'siteName' => 'BuzzingPixel',
        'siteUrl' => getenv('SITE_URL'),
        'suppressTemplateErrors' => getenv('DEV_MODE') !== 'true',
        'timezone' => 'America/Chicago',
        'useEmailAsUsername' => true,
        'userSessionDuration' => 0,
        'staticAssetCacheTime' => '',
    ],
];

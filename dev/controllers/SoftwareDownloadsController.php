<?php

namespace dev\controllers;

use Craft;
use yii\web\Response;
use modules\store\Store;
use yii\web\HttpException;
use modules\store\models\StoreProductModel;
use \modules\store\factories\OrderItemsQueryFactory;

/**
 * Class SoftwareDownloadsController
 */
class SoftwareDownloadsController extends BaseController
{
    /**
     * Downloads controller index
     * @return Response
     * @throws HttpException
     */
    public function actionIndex(): Response
    {
        $request = Craft::$app->getRequest();
        $key = $request->get('key');

        $products = Store::settings()->products;

        if (! isset($products[$key])) {
            throw new HttpException(404, 'Product not found');
        }

        $product = $products[$key];

        if ($product->publicDownload) {
            return $this->runDownload($product);
        }

        $version = $request->get('version', $product->currentVersion);

        $path = CRAFT_BASE_PATH . '/softwareDownloads/' . $product->key. '/';
        $path .= $product->key . '-' . $version . '.zip';

        if (! file_exists($path)) {
            throw new HttpException(
                404,
                'That version does not have a download'
            );
        }

        $licenses = OrderItemsQueryFactory::getFactory()
            ->where('userId', Craft::$app->getUser()->getId())
            ->where('disabled', 0)
            ->where('key', $key)
            ->all();

        $hasValidVersion = false;

        foreach ($licenses as $license) {
            if (version_compare($license->version, $version, '>=')) {
                $hasValidVersion = true;
                break;
            }
        }

        if (! $hasValidVersion) {
            throw new HttpException(
                404,
                "You don't have access to this product"
            );
        }

        return $this->runDownload($product);
    }

    /**
     * Runs the download (displays license agreement if applicable)
     * @param StoreProductModel $product
     * @return Response
     */
    public function runDownload(StoreProductModel $product): Response
    {
        $request = Craft::$app->getRequest();

        $version = $request->get('version', $product->currentVersion);

        $agree = true;

        if ($product->licenseAgreementMarkdownFile) {
            $agree = $request->get('agree') === 'true';
        }

        if (! $agree) {
            $query = [
                'key' => $product->key,
                'version' => $version,
                'agree' => 'true',
            ];

            $downloadUrl = '/software/download?' . http_build_query($query);
            $licenseContent = file_get_contents(
                CRAFT_BASE_PATH . '/' . $product->licenseAgreementMarkdownFile
            );

            $title = 'License Agreement: ' . $product->title;

            return $this->renderTemplate(
                '_core/PageStandard.twig',
                [
                    'contentModel' => null,
                    'content' => null,
                    'contentMeta' => null,
                    'metaTitle' => $title,
                    'metaDescription' => null,
                    'header' => [
                        'meta' => [
                            'heading' => $title,
                        ],
                    ],
                    'contentBlocks' => [
                        [
                            'meta' => [
                                'blockType' => 'softwareDownloadLicenseAgreement',
                                'downloadUrl' => $downloadUrl,
                                'licenseContent' => $licenseContent,
                            ],
                        ],
                    ],
                ],
                false
            );
        }

        $path = CRAFT_BASE_PATH . '/softwareDownloads/' . $product->key. '/';
        $path .= $product->key . '-' . $version . '.zip';

        // Set headers and read file contents out
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        flush();
        readfile($path);

        exit();
    }
}

<?php

namespace dev\controllers;

use Craft;
use dev\Module;
use yii\web\Response;
use modules\store\Store;
use yii\web\HttpException;
use dev\services\PaginationGeneratorService;
use modules\store\factories\OrderItemsQueryFactory;

/**
 * Class AccountController
 */
class AccountController extends BaseController
{
    private static $secionNav = [
        'licenses' => [
            'content' => 'Licenses',
            'url' => '/account',
            'isActive' => false,
        ],
        'payment' => [
            'content' => 'Payment Methods',
            'url' => '/account/payment',
            'isActive' => false,
        ],
        'subscriptions' => [
            'content' => 'Subscriptions',
            'url' => '/account/subscriptions',
            'isActive' => false,
        ],
        'profile' => [
            'content' => 'Profile',
            'url' => '/account/profile',
            'isActive' => false,
        ],
    ];

    /** @var int $pageLimit */
    private static $pageLimit = 12;

    /**
     * Displays user account page
     * @param int $pageNum
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(int $pageNum = null): Response
    {
        if ($pageNum === 1) {
            throw new HttpException(404);
        }

        $craftUser = Craft::$app->getUser();

        // If the user is a guest, we need for them to log in
        if ($craftUser->getIsGuest()) {
            return $this->renderTemplate(
                '_core/StandAloneLoginForm.twig',
                array_merge(Craft::$app->getUrlManager()->getRouteParams(), [
                    'metaTitle' => 'Log in to your account',
                    'metaDescription' => null,
                ]),
                false
            );
        }

        $request = Craft::$app->getRequest();

        $filter = $request->get('filter');

        $licensesQuery = OrderItemsQueryFactory::getFactory()
            ->where('userId', $craftUser->getId())
            ->where('disabled', 0)
            ->orderBy('id');

        if ($filter) {
            $licensesQuery->like('key', $filter)
                ->like('title', $filter, true)
                ->like('licenseKey', $filter, true)
                ->like('notes', $filter, true)
                ->like('authorizedDomains', $filter, true);
        }

        $pageNum = $pageNum ?: 1;
        $limit = self::$pageLimit;
        $total = $licensesQuery->count();
        $offset = ($limit * $pageNum) - $limit;
        $maxPages = ((int) ceil($total / $limit)) ?: 1;

        if ($pageNum > $maxPages) {
            throw new HttpException(404);
        }

        $licenses = $licensesQuery->limit($limit)
            ->offset($offset)
            ->all();

        $metaTitle = 'Your Licenses';

        $segmentsArray = Craft::$app->getRequest()->getSegments();

        $redirectUrl = '/' . implode('/', $segmentsArray);

        if ($filter) {
            $redirectUrl .= '?filter=' . $filter;
        }

        if ($pageNum > 1) {
            $metaTitle .= " | Page {$pageNum}";
            array_pop($segmentsArray);
            array_pop($segmentsArray);
        }

        $listingBase = '/' . implode('/', $segmentsArray);

        $pagination = PaginationGeneratorService::getPagination([
            'currentPage' => $pageNum,
            'perPage' => $limit,
            'totalResults' => $total,
            'base' => $listingBase,
        ]);

        $breadcrumbs = [];

        if ($pageNum > 1 || $filter) {
            $breadcrumbs = [
                [
                    'link' => $listingBase,
                    'content' => 'Your Licenses',
                ],
            ];

            if ($pageNum > 1 && $filter) {
                $breadcrumbs[] = [
                    'link' => $listingBase . '?' . $request->getQueryString(),
                    'content' => 'Filtering by Keyword',
                ];
            } elseif ($filter) {
                $breadcrumbs[] = [
                    'link' => false,
                    'content' => 'Filtering by Keyword',
                ];
            }

            if ($pageNum > 1) {
                $breadcrumbs[] = [
                    'link' => false,
                    'content' => "Page {$pageNum}",
                ];
            }
        }

        $sectionNav = self::$secionNav;
        $sectionNav['licenses']['isActive'] = true;

        return $this->renderTemplate(
            '_core/PageStandard.twig',
            [
                'breadcrumbs' => $breadcrumbs,
                'contentModel' => null,
                'content' => null,
                'contentMeta' => null,
                'metaTitle' => $metaTitle,
                'metaDescription' => null,
                'header' => [
                    'meta' => [
                        'heading' => 'Your Licenses',
                    ],
                ],
                'contentBlocks' => [
                    [
                        'meta' => [
                            'blockType' => 'navBar',
                            'navItems' => $sectionNav
                        ],
                    ],
                    [
                        'meta' => [
                            'blockType' => 'licenses',
                            'baseUrl' => $listingBase,
                            'redirectUrl' => $redirectUrl,
                            'currentFilter' => $filter,
                            'items' => $licenses,
                            'pagination' => $pagination,
                        ],
                    ],
                ],
            ],
            false
        );
    }

    /**
     * Displays user's cards
     * @return Response
     * @throws \Exception
     */
    public function actionPayment(): Response
    {
        $craftUser = Craft::$app->getUser();

        // If the user is a guest, we need for them to log in
        if ($craftUser->getIsGuest()) {
            return $this->renderTemplate(
                '_core/StandAloneLoginForm.twig',
                array_merge(Craft::$app->getUrlManager()->getRouteParams(), [
                    'metaTitle' => 'Log in to your account',
                    'metaDescription' => null,
                    'redirectUrl' => '/account/payment'
                ]),
                false
            );
        }

        $userCards = Store::stripeUserService()->getUserCards(
            Module::userService()->getUserModel()
        );

        $sectionNav = self::$secionNav;
        $sectionNav['payment']['isActive'] = true;

        return $this->renderTemplate(
            '_core/PageStandard.twig',
            [
                'contentModel' => null,
                'content' => null,
                'contentMeta' => null,
                'metaTitle' => 'Your Payment Methods',
                'metaDescription' => null,
                'header' => [
                    'meta' => [
                        'heading' => 'Your Payment Methods',
                    ],
                ],
                'contentBlocks' => [
                    [
                        'meta' => [
                            'blockType' => 'navBar',
                            'navItems' => $sectionNav
                        ],
                    ],
                    [
                        'meta' => [
                            'blockType' => 'paymentMethods',
                            'items' => $userCards,
                            'redirectUrl' => '/account/payment',
                        ]
                    ],
                ],
            ],
            false
        );
    }

    /**
     * Displays forgot password page
     * @throws HttpException
     */
    public function actionForgotPassword()
    {
        if (! Craft::$app->getUser()->getIsGuest()) {
            throw new HttpException(400, 'User is already logged in');
        }

        return $this->renderTemplate(
            '_core/ResetPassword.twig',
            array_merge(Craft::$app->getUrlManager()->getRouteParams(), [
                'metaTitle' => 'Reset Your Password',
                'metaDescription' => null,
                'header' => [
                    'meta' => [
                        'heading' => 'Reset Your Password',
                    ],
                ],
            ]),
            false
        );
    }
}

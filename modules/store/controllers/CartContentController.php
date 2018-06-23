<?php

namespace modules\store\controllers;

use Craft;
use dev\Module;
use yii\web\Response;
use modules\store\Store;
use craft\web\Controller;
use yii\web\HttpException;
use modules\store\models\PaymentModel;

/**
 * Class CartContentController
 */
class CartContentController extends Controller
{
    protected $allowAnonymous = true;

    /**
     * Adds an item to the cart
     * @param string $productKey
     * @return Response
     * @throws \Exception
     */
    public function actionAdd(string $productKey): Response
    {
        if (! Store::cartService()->add($productKey)) {
            throw new HttpException(500, 'Product not found');
        }

        return $this->redirect(
            Craft::$app->getRequest()->get('redirect', '/cart')
        );
    }

    /**
     * Removes an item to the cart
     * @param string $productKey
     * @return Response
     * @throws \Exception
     */
    public function actionRemove(string $productKey): Response
    {
        if (! Store::cartService()->remove($productKey)) {
            if (Craft::$app->getRequest()->getIsAjax()) {
                return $this->asJson([
                    'success' => false,
                    'message' => 'Product not found',
                ]);
            }

            throw new HttpException(500, 'Product not found');
        }

        if (Craft::$app->getRequest()->getIsAjax()) {
            return $this->asJson([
                'success' => true,
                'message' => '',
            ]);
        }

        return $this->redirect(
            Craft::$app->getRequest()->get('redirect', '/cart')
        );
    }

    /**
     * Gets the cart count and outputs AJAX
     * @return Response
     * @throws \Exception
     */
    public function actionAjaxCount(): Response
    {
        return $this->asJson([
            'count' => Store::cartService()->count(),
        ]);
    }

    /**
     * Updates an item in the cart
     * @return Response
     * @throws \Exception
     */
    public function actionUpdateItem(): Response
    {
        $request = Craft::$app->getRequest();

        $result = Store::cartService()->updateItemQty(
            $request->getParam('productKey'),
            (int) $request->getParam('qty')
        );

        if (! $result) {
            if (Craft::$app->getRequest()->getIsAjax()) {
                return $this->asJson([
                    'success' => false,
                    'message' => 'Product not found',
                ]);
            }

            throw new HttpException(500, 'Product not found');
        }

        if (Craft::$app->getRequest()->getIsAjax()) {
            return $this->asJson([
                'success' => true,
                'message' => '',
            ]);
        }

        return $this->redirect(
            Craft::$app->getRequest()->getParam('redirect', '/cart')
        );
    }

    /**
     * Updates cart details
     * @return Response
     * @throws \Exception
     */
    public function actionUpdateCartDetails(): Response
    {
        $request = Craft::$app->getRequest();

        $cartService = Store::cartService();

        $cartModel = $cartService->getCartModel();

        foreach (array_keys($cartModel->getSaveData(false, true)) as $key) {
            $cartModel->{$key} = $request->getParam($key);
        }

        $cartService->updateCart();

        if (Craft::$app->getRequest()->getIsAjax()) {
            return $this->asJson([
                'success' => true,
            ]);
        }

        return $this->redirect(
            Craft::$app->getRequest()->getParam('redirect', '/cart')
        );
    }

    /**
     * Returns an AJAX response for cart pricing info
     * @return Response
     * @throws \Exception
     */
    public function actionPricingInfo(): Response
    {
        $cartModel = Store::cartService()->getCartModel();

        return $this->asJson([
            'subTotal' => number_format($cartModel->getSubTotal(), 2),
            'tax' => number_format($cartModel->getTax(), 2),
            'total' => number_format($cartModel->getTotal(), 2),
        ]);
    }

    /**
     * Checks user out
     * @return Response|null
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionCheckout()
    {
        try {
            return $this->checkout();
        } catch (\Exception $e) {
            var_dump($e);
            die;
            return $this->catchRespond($e);
        } catch (\Throwable $e) {
            var_dump($e);
            die;
            return $this->catchRespond($e);
        }
    }

    /**
     * Inner checkout method so we can do a single try/catch
     * @return null|Response
     * @throws \Exception
     * @throws \Throwable
     */
    private function checkout()
    {
        $userService = Module::userService();

        $stripeUserService = Store::stripeUserService();

        $userModel = $userService->getUserModel();

        $request = Craft::$app->getRequest();

        $cartService = Store::cartService();

        $cartModel = $cartService->getCartModel();

        foreach (array_keys($cartModel->getSaveData(false, true)) as $key) {
            $cartModel->{$key} = $request->getParam($key);
        }

        if (! $cartModel->paymentMethod) {
            if (Craft::$app->getRequest()->getIsAjax()) {
                return $this->asJson([
                    'success' => false,
                    'message' => '',
                    'checkoutInputErrors' => [
                        'paymentMethod' => [
                            'This field is required',
                        ],
                    ],
                ]);
            }

            Craft::$app->getUrlManager()->setRouteParams([
                'checkoutInputErrors' => [
                    'paymentMethod' => [
                        'This field is required',
                    ],
                ],
            ]);

            return null;
        }

        $cardModel = null;

        if ($cartModel->paymentMethod === 'addNew') {
            $paymentModel = new PaymentModel();

            foreach ($paymentModel->getProperties() as $key) {
                $paymentModel->{$key} = $request->getParam($key);
            }

            $cartValidationErrors = array_merge(
                $cartModel->validateForCheckout(),
                $paymentModel->validateForCheckout()
            );

            if (\count($cartValidationErrors) > 0) {
                if (Craft::$app->getRequest()->getIsAjax()) {
                    return $this->asJson([
                        'success' => false,
                        'message' => '',
                        'checkoutInputErrors' => $cartValidationErrors,
                    ]);
                }

                Craft::$app->getUrlManager()->setRouteParams([
                    'checkoutInputErrors' => $cartValidationErrors
                ]);

                return null;
            }

            $stripeUserService->touchStripeUser($userModel);

            $cardModel = $stripeUserService->addUserCard(
                $userModel,
                $paymentModel,
                $cartModel
            );
        }

        var_dump($cardModel);
        die;

        $cartValidationErrors = array_merge(
            $cartModel->validateForCheckout(),
            $paymentModel->validateForCheckout()
        );

        $charge = Store::chargeCardService()->charge(
            $paymentModel,
            $cartModel,
            $userModel
        );

        $orderId = Store::orderService()->createOrderFromCharge(
            $charge,
            $cartModel
        );

        var_dump($charge, $orderId);
        die;

        // $userService->populateUserModelFromCartModel($userModel, $cartModel);
    }

    /**
     * Responds to catch
     * @param \Throwable|\Exception $e
     * @return null|Response
     */
    private function catchRespond($e)
    {
        if (Craft::$app->getRequest()->getIsAjax()) {
            return $this->asJson([
                'success' => false,
                'message' => $e->getMessage(),
                'checkoutInputErrors' => [],
            ]);
        }

        Craft::$app->getUrlManager()->setRouteParams([
            'checkoutErrorMessage' => $e->getMessage()
        ]);

        return null;
    }
}

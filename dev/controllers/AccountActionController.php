<?php

namespace dev\controllers;

use Craft;
use yii\web\Response;
use craft\elements\User;
use yii\web\HttpException;
use craft\helpers\DateTimeHelper;

/**
 * Class AccountActionController
 */
class AccountActionController extends BaseController
{
    /**
     * Logs the user in
     * @throws \Exception
     * @return Response|null
     * @see \craft\controllers\UsersController::actionLogin()
     */
    public function actionLogin()
    {
        $this->requirePostRequest();

        if (! Craft::$app->getUser()->getIsGuest()) {
            throw new HttpException(400, 'User is already logged in');
        }

        // First, a little house-cleaning for expired, pending users.
        Craft::$app->getUsers()->purgeExpiredPendingUsers();

        $loginName = Craft::$app->getRequest()->getBodyParam('loginName');
        $password = Craft::$app->getRequest()->getBodyParam('password');
        $rememberMe = (bool) Craft::$app->getRequest()->getBodyParam('rememberMe');

        // Does a user exist with that username/email?
        $user = Craft::$app->getUsers()->getUserByUsernameOrEmail($loginName);

        // Delay randomly between 0 and 1.5 seconds.
        usleep(random_int(0, 1500000));

        if (! $user || $user->password === null) {
            return $this->handleLoginFailure(
                User::AUTH_INVALID_CREDENTIALS,
                $user
            );
        }

        if (! $user->authenticate($password)) {
            return $this->handleLoginFailure($user->authError, $user);
        }

        // Get the session duration
        $generalConfig = Craft::$app->getConfig()->getGeneral();
        $duration = $generalConfig->userSessionDuration;
        if ($rememberMe && $generalConfig->rememberedUserSessionDuration !== 0) {
            $duration = $generalConfig->rememberedUserSessionDuration;
        }

        // Try logging them in
        if (! Craft::$app->getUser()->login($user, $duration)) {
            return $this->handleLoginFailure(null, $user);
        }

        return $this->handleSuccessfulLogin();
    }

    /**
     * Handles login failure
     * @return Response
     * @throws \Exception
     */
    private function handleSuccessfulLogin(): Response
    {
        $userService = Craft::$app->getUser();

        $returnUrl = Craft::$app->getSecurity()->validateData(
            Craft::$app->getRequest()->getBodyParam('redirect')
        );

        if (! $returnUrl) {
            $returnUrl = $userService->getReturnUrl();
            $userService->removeReturnUrl();
        }

        return $this->redirectToPostedUrl(
            $userService->getIdentity(),
            $returnUrl
        );
    }

    /**
     * Handles login failure
     * @param string $authError
     * @param User $user
     * @return Response|null
     */
    private function handleLoginFailure(
        string $authError = null,
        User $user = null
    ) {
        switch ($authError) {
            case User::AUTH_PENDING_VERIFICATION:
                $message = Craft::t('app', 'Account has not been activated.');
                break;
            case User::AUTH_ACCOUNT_LOCKED:
                $message = Craft::t('app', 'Account locked.');
                break;
            case User::AUTH_ACCOUNT_COOLDOWN:
                $timeRemaining = null;

                if ($user !== null) {
                    $timeRemaining = $user->getRemainingCooldownTime();
                }

                $message = Craft::t('app', 'Account locked.');

                if ($timeRemaining) {
                    $message = Craft::t(
                        'app',
                        'Account locked. Try again in {time}.',
                        [
                            'time' => DateTimeHelper::humanDurationFromInterval(
                                $timeRemaining
                            ),
                        ]
                    );
                }

                break;
            case User::AUTH_PASSWORD_RESET_REQUIRED:
                $message = Craft::t(
                    'app',
                    'You need to reset your password, but an error was encountered when sending the password reset email.'
                );

                if (Craft::$app->getUsers()->sendPasswordResetEmail($user)) {
                    $message = Craft::t(
                        'app',
                        'You need to reset your password. Check your email for instructions.'
                    );
                }

                break;
            case User::AUTH_ACCOUNT_SUSPENDED:
                $message = Craft::t('app', 'Account suspended.');
                break;
            case User::AUTH_NO_CP_ACCESS:
                $message = Craft::t('app', 'You cannot access the CP with that account.');
                break;
            case User::AUTH_NO_CP_OFFLINE_ACCESS:
                $message = Craft::t('app', 'You cannot access the CP while the system is offline with that account.');
                break;
            case User::AUTH_NO_SITE_OFFLINE_ACCESS:
                $message = Craft::t('app', 'You cannot access the site while the system is offline with that account.');
                break;
            default:
                $message = Craft::t('app', 'Invalid username or password.');

                if (Craft::$app->getConfig()->getGeneral()->useEmailAsUsername) {
                    $message = Craft::t('app', 'Invalid email or password.');
                }
        }

        if (Craft::$app->getRequest()->getAcceptsJson()) {
            return $this->asJson([
                'errorCode' => $authError,
                'error' => $message
            ]);
        }

        Craft::$app->getSession()->setFlash('error', $message);

        return null;
    }
}

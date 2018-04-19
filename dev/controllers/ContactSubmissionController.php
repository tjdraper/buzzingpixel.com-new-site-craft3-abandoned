<?php

namespace dev\controllers;

use Craft;
use yii\web\Response;
use craft\mail\Message;
use craft\web\Controller;
use dev\services\StorageService;

/**
 * Class ContactSubmissionController
 */
class ContactSubmissionController extends Controller
{
    /** @var bool $allowAnonymous */
    protected $allowAnonymous = true;

    /** @var bool $isAjax */
    private $isAjax = false;

    /** @var StorageService $storage */
    private $storage;

    /** @var array $inputValues */
    private $inputValues = [
        'site' => '', // Honeypot
        'mailingAddress' => '', // Honeypot
        'name' => '',
        'email' => '',
        'message' => '',
    ];

    private $redirectUri = '/';

    /**
     * Init runs on controller construction
     */
    public function init()
    {
        $this->storage = StorageService::getInstance();

        $request = Craft::$app->getRequest();

        $this->isAjax = $request->isAjax;

        $this->redirectUri = $request->post('redirect');

        foreach ($this->inputValues as $key => &$val) {
            $val = $request->post($key);
        }
    }

    /**
     * Handles contact form submissions
     * @return null|Response
     * @throws \Exception
     */
    public function actionHandleSubmission()
    {
        $this->requirePostRequest();

        $this->storage->set($this->inputValues, 'ContactInputValues');

        $message = 'We were unable to validate your form submission';

        // Check our honeypot fields
        if ($this->inputValues['site'] ||
            $this->inputValues['mailingAddress']
        ) {
            if ($this->isAjax) {
                return $this->asJson([
                    'success' => false,
                    'message' => $message,
                    'redirect' => $this->redirectUri,
                    'inputErrors' => [],
                ]);
            }
            $this->storage->set(true, 'ContactHasErrors');
            $this->storage->set($message, 'ContactErrorMessage');
            return null;
        }

        $inputErrors = [];

        if (! $this->inputValues['name']) {
            $inputErrors['name'] = 'Name is required';
        }

        if (! $this->inputValues['email']) {
            $inputErrors['email'] = 'Email is required';
        }

        if ($this->inputValues['email']) {
            $validEmail = filter_var(
                $this->inputValues['email'],
                FILTER_VALIDATE_EMAIL
            );

            if (! $validEmail) {
                $inputErrors['email'] = 'A valid email address is required';
            }
        }

        if (! $this->inputValues['message']) {
            $inputErrors['message'] = 'Message is required';
        }

        $this->storage->set($inputErrors, 'ContactInputErrors');

        if ($inputErrors) {
            if ($this->isAjax) {
                return $this->asJson([
                    'success' => false,
                    'message' => $message,
                    'redirect' => $this->redirectUri,
                    'inputErrors' => $inputErrors,
                ]);
            }
            $this->storage->set($message, 'ContactErrorMessage');
            return null;
        }

        return $this->sendMessage();
    }

    /**
     * Sends the message
     * @return null|Response
     */
    private function sendMessage()
    {
        $message = new Message();

        $to = [
            'tj@buzzingpixel.com',
        ];

        $message->setFrom('info@buzzingpixel.com');
        $message->setSubject('BuzzingPixel Contact Form');
        $message->setTo($to);
        $message->setReplyTo([
            $this->inputValues['email'] => $this->inputValues['name']
        ]);

        $html = "<strong>From Name:</strong> {$this->inputValues['name']}<br>";
        $text = "From Name: {$this->inputValues['name']}\n";

        $html .= "<strong>From Email:</strong> {$this->inputValues['email']}<br>";
        $text .= "From Email: {$this->inputValues['email']}\n";

        $html .= '<strong>Message:</strong> ' .
            nl2br($this->inputValues['message']);
        $text .= "Message: {$this->inputValues['message']}";

        $message->setHtmlBody($html);
        $message->setTextBody($text);

        Craft::$app->getMailer()->send($message);

        if ($this->isAjax) {
            return $this->asJson([
                'success' => true,
                'message' => '',
                'redirect' => $this->redirectUri,
                'inputErrors' => [],
            ]);
        }

        $this->redirect($this->redirectUri);

        return null;
    }
}

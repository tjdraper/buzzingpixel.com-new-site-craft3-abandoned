<?php

namespace modules\store\factories;

use modules\store\services\CookieService;
use yii\web\Cookie;
use yii\web\CookieCollection;

/**
 * Class CookieFactory
 */
class CookieFactory
{
    /**
     * Gets a new query class
     * @return Cookie
     */
    public function getCookie(): Cookie
    {
        $cookie = new Cookie();
        $cookie->expire = strtotime('+20 years');
        $cookie->httpOnly = true;
        return $cookie;
    }
}

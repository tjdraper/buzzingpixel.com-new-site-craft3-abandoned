<?php

namespace modules\store\factories;

use yii\web\Cookie;

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

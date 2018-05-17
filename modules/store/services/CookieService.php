<?php

namespace modules\store\services;

use yii\web\Cookie;
use modules\store\factories\CookieFactory;

/**
 * Class CookieService
 */
class CookieService
{
    /** @var array $cookies */
    private $cookies;

    /** @var CookieFactory $cookieFactory */
    protected $cookieFactory;

    /**
     * CookieService constructor
     * @param array $cookies
     * @param CookieFactory $cookieFactory
     */
    public function __construct(array $cookies, CookieFactory $cookieFactory)
    {
        $this->cookieFactory = $cookieFactory;
        $this->setCookies($cookies);
    }

    /**
     * Set cookies
     * @param array $cookies
     */
    private function setCookies(array $cookies)
    {
        $cookieClasses = [];

        foreach ($cookies as $name => $val) {
            $cookie = $this->cookieFactory->getCookie();

            $cookie->name = $name;
            $cookie->value = $val;

            $cookieClasses[$name] = $cookie;
        }

        $this->cookies = $cookieClasses;
    }

    /**
     * Creates a Cookie class and returns it
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param bool httpOnly
     * @return Cookie
     */
    public function createCookie(
        string $name = null,
        string $value = '',
        int $expire = null,
        bool $httpOnly = true
    ): Cookie {
        $cookie = $this->cookieFactory->getCookie();

        if ($name) {
            $cookie->name = $name;
        }

        if ($value) {
            $cookie->value = $value;
        }

        if ($expire) {
            $cookie->expire = $expire;
        }

        $cookie->httpOnly = $httpOnly;

        return $cookie;
    }

    /**
     * Get's a cookie if it exists
     * @param string $name
     * @return Cookie|null
     */
    public function get(string $name)
    {
        if (! isset($this->cookies[$name])) {
            return null;
        }

        return $this->cookies[$name];
    }

    /**
     * Adds a cookie
     * @param Cookie $cookie
     * @throws \LogicException
     */
    public function add(Cookie $cookie)
    {
        if (! $cookie->name) {
            throw new \LogicException('Cookie name must be defined');
        }

        if (! $cookie->value) {
            throw new \LogicException('Cookie value must be defined');
        }

        setcookie(
            $cookie->name,
            $cookie->value,
            $cookie->expire,
            $cookie->path,
            $cookie->domain,
            $cookie->secure,
            $cookie->httpOnly
        );

        $this->cookies[$cookie->name] = $cookie;
    }
}

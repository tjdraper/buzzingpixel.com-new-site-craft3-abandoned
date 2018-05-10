<?php

namespace dev\twigextensions;

use Twig_Function;
use Twig_Extension;
use League\ISO3166\ISO3166;

/**
 * Class CountriesTwigExtension
 */
class CountriesTwigExtension extends Twig_Extension
{
    /**
     * Returns the functions for this Twig Extension
     * @return Twig_Function[]
     */
    public function getFunctions(): array
    {
        return [
            new Twig_Function('countries', [$this, 'getISO3166']),
        ];
    }

    /**
     * @return ISO3166
     */
    public function getISO3166(): ISO3166
    {
        return new ISO3166();
    }
}

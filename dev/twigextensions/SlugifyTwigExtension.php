<?php

namespace dev\twigextensions;

use Twig_Markup;
use Twig_Filter;
use Twig_Extension;
use Cocur\Slugify\Slugify;
use craft\helpers\Template;

/**
 * Class SlugifyTwigExtension
 */
class SlugifyTwigExtension extends Twig_Extension
{
    /**
     * Returns the twig filters
     * @return Twig_Filter[]
     */
    public function getFilters() : array
    {
        return [
            new Twig_Filter('slugify', [$this, 'slugifyFilter']),
        ];
    }

    /**
     * Runs the slugify filter
     * @param string $str
     * @return Twig_Markup
     */
    public function slugifyFilter(string $str): Twig_Markup
    {
        return Template::raw((new Slugify())->slugify($str));
    }
}

<?php

namespace dev\twigextensions;

use dev\Module;
use Twig_Filter;
use Twig_Markup;
use Twig_Extension;
use TS\Text\Truncation;
use craft\helpers\Template;

/**
 * Class TypesetTwigExtension
 */
class TypesetTwigExtension extends Twig_Extension
{
    /**
     * Returns the twig filters
     * @return Twig_Filter[]
     */
    public function getFilters() : array
    {
        return [
            new Twig_Filter('typeset', [$this, 'typesetFilter']),
            new Twig_Filter('smartypants', [$this, 'smartypantsFilter']),
            new Twig_Filter('widont', [$this, 'widontFilter']),
            new Twig_Filter('truncate', [$this, 'truncate']),
            new Twig_Filter('ucfirst', [$this, 'ucfirst']),
        ];
    }

    /**
     * Runs the typeset service as a Twig Filter
     * @param string $str
     * @return Twig_Markup
     */
    public function typesetFilter(string $str): Twig_Markup
    {
        return Template::raw(Module::typesetService()->typeset($str));
    }

    /**
     * Runs smartypants as a Twig Filter
     * @param string $str
     * @return Twig_Markup
     */
    public function smartypantsFilter(string $str): Twig_Markup
    {
        return Template::raw(Module::typesetService()->smartypants($str));
    }

    /**
     * Runs widont as a Twig Filter
     * @param string $str
     * @return Twig_Markup
     */
    public function widontFilter(string $str): Twig_Markup
    {
        return Template::raw(Module::typesetService()->widont($str));
    }

    /**
     * Truncates HTML/text as a Twig Filter
     * @param string $val
     * @param int $limit
     * @param string $strategy Defaults to word
     * @return  \Twig_Markup
     * @throws \Exception
     */
    public function truncate(
        string $val,
        int $limit,
        string $strategy = 'word'
    ) : \Twig_Markup {
        $strategies = [
            'char' => Truncation::STRATEGY_CHARACTER,
            'line' => Truncation::STRATEGY_LINE,
            'paragraph' => Truncation::STRATEGY_PARAGRAPH,
            'sentence' => Truncation::STRATEGY_SENTENCE,
            'word' => Truncation::STRATEGY_WORD,
        ];

        $strategy = $strategies[$strategy];

        $truncation = new Truncation($limit, $strategy);

        return Template::raw($truncation->truncate($val));
    }

    /**
     * Uppercases first letter as a Twig Filter
     * @param string $val
     * @return \Twig_Markup
     */
    public function ucfirst(string $val) : \Twig_Markup
    {
        return Template::raw(ucfirst($val));
    }
}

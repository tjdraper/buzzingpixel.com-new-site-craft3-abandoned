<?php

namespace dev\twigextensions;

use dev\Module;
use Twig_Function;
use Twig_Extension;

/**
 * Class FileTimeTwigExtension
 */
class FileTimeTwigExtension extends Twig_Extension
{
    /**
     * Returns the functions for this Twig Extension
     * @return Twig_Function[]
     */
    public function getFunctions(): array
    {
        return [
            new Twig_Function('fileTime', [
                Module::fileOperationsService(),
                'getFileTime'
            ]),
        ];
    }
}

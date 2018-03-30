<?php

namespace dev\services;

use craft\web\twig\Environment as TwigEnvironment;

/**
 * Class GlobalsService
 */
class GlobalsService
{
    /** @var TwigEnvironment $twig */
    private $twig;

    /**
     * GlobalsService constructor
     * @param TwigEnvironment $twig
     */
    public function __construct(TwigEnvironment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Registers globals from PHP files in a directory
     * @param string $dir
     */
    public function registerGlobalsFromDir(string $dir)
    {
        foreach (new \DirectoryIterator($dir) as $fileInfo) {
            if ($fileInfo->isDot() || $fileInfo->getExtension() !== 'php') {
                continue;
            }

            $vars = require $fileInfo->getPathname();

            $this->twig->addGlobal($fileInfo->getBasename('.php'), $vars);
        }
    }
}

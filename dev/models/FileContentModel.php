<?php

namespace dev\models;

use Hyn\Frontmatter\Parser;
use felicity\datamodel\Model;
use cebe\markdown\GithubMarkdown as Markdown;
use felicity\datamodel\services\datahandlers\ArrayHandler;
use felicity\datamodel\services\datahandlers\StringHandler;

/**
 * Class FileContentModel
 */
class FileContentModel extends Model
{
    /** @var string $contentFile */
    public $contentFile;

    /** @var array $parsedContent */
    private $parsedContent;

    /** @var array $files */
    public $files = [];

    /** @var array $parsedFiles */
    private $parsedFiles = [];

    /** @var array $children */
    public $children = [];

    /**
     * @inheritdoc
     */
    protected function defineHandlers() : array
    {
        return [
            'contentFile' => StringHandler::class,
            'files' => ArrayHandler::class,
            'children' => ArrayHandler::class,
        ];
    }

    /**
     * Gets content
     * @return mixed
     */
    public function getContent()
    {
        if (! file_exists($this->contentFile)) {
            return null;
        }

        if (\is_array($this->parsedContent)) {
            return $this->parsedContent;
        }

        return $this->parsedContent = (new Parser(new Markdown()))->parse(
            file_get_contents($this->contentFile)
        );
    }

    /**
     * Adds a file location
     * @param string $file
     * @param string $index
     */
    public function addFile(string $file, string $index = null)
    {
        if ($index) {
            $this->files[$index] = $file;
            return;
        }

        $this->files[] = $file;
    }

    /**
     * Adds a child model
     * @param FileContentModel $model
     * @param string $index
     */
    public function addChildModel(FileContentModel $model, string $index = null)
    {
        if ($index) {
            $this->children[$index] = $model;
            return;
        }

        $this->children[] = $model;
    }

    /**
     * Gets the array keys of the files
     * @return array
     */
    public function getKeys() : array
    {
        return array_keys($this->files);
    }

    /**
     * Gets the array keys of the children
     * @return array
     */
    public function getChildKeys() : array
    {
        return array_keys($this->children);
    }

    /**
     * Gets array of all vars
     * @return array
     */
    public function getVars(): array
    {
        $keys = $this->getKeys();

        $vars = [];

        foreach ($keys as $key) {
            $vars[] = $this->getVarsAtIndex($key);
        }

        return $vars;
    }

    /**
     * Gets content at index
     * @param string $index
     * @return array|null
     */
    public function getVarsAtIndex(string $index)
    {
        if (! isset($this->files[$index])) {
            return null;
        }

        if (isset($this->parsedFiles[$index])) {
            return $this->parsedFiles[$index];
        }

        return $this->parsedFiles[$index] = (new Parser(new Markdown()))->parse(
            file_get_contents($this->files[$index])
        );
    }

    /**
     * Gets child at index
     * @param $index
     * @return FileContentModel|null
     */
    public function getChildAtIndex(string $index)
    {
        if (! isset($this->children[$index])) {
            return null;
        }

        return $this->children[$index];
    }
}

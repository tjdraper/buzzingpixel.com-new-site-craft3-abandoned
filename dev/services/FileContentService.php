<?php

namespace dev\services;

use dev\models\FileContentModel;

/**
 * Class FileContentService
 */
class FileContentService
{
    /** @var string $config */
    private $contentPath;

    /**
     * FileContentService constructor
     * @param string $contentPath
     */
    public function __construct(string $contentPath)
    {
        $this->contentPath = $contentPath;
    }

    /**
     * Gets page content from directory
     * @param string $directory
     * @return FileContentModel
     * @throws \Exception
     */
    public function getContentFromDir(string $directory): FileContentModel
    {
        return $this->getContentFromDirInner(
            "{$this->contentPath}/{$directory}"
        );
    }

    /**
     * @param string $fullPath
     * @return FileContentModel;
     * @throws \Exception
     */
    private function getContentFromDirInner(string $fullPath): FileContentModel
    {
        $dirIterator = new \DirectoryIterator($fullPath);

        $model = new FileContentModel();

        foreach ($dirIterator as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }

            $fileName = $fileInfo->getBasename('.md');

            if (strtolower($fileName) === 'index') {
                $model->contentFile = $fileInfo->getPathname();
                continue;
            }

            $fileName = explode('-', $fileName);
            if (\count($fileName) > 1 && is_numeric($fileName[0])) {
                unset($fileName[0]);
            }
            $fileName = implode('-', $fileName);

            if ($fileInfo->isDir()) {
                $model->addChildModel(
                    $this->getContentFromDirInner(
                        $fileInfo->getPathname()
                    ),
                    $fileName
                );
                continue;
            }

            $model->addFile(
                $fileInfo->getPathname(),
                $fileName
            );
        }

        return $model;
    }
}

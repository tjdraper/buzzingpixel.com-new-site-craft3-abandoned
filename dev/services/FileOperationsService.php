<?php

namespace dev\services;

/**
 * Class FileOperationsService
 */
class FileOperationsService
{
    /** @var string $basePath */
    private $basePath;

    /**
     * FileOperationsService constructor
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Gets a file's modification time
     * @param string $filePath
     * @return string
     */
    public function getFileTime(string $filePath = ''): string
    {
        if (file_exists($filePath)) {
            return (string) filemtime($filePath);
        }

        $filePath = ltrim($filePath, '/');
        $newPath = "{$this->basePath}/{$filePath}";

        if (file_exists($newPath)) {
            return (string) filemtime($newPath);
        }

        return uniqid('', false);
    }
}

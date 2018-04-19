<?php

namespace dev\variables;

use dev\Module;
use dev\services\StorageService;

/**
 * Class StorageVariable
 */
class StorageVariable
{
    /**
     * Gets the file content service
     * @return StorageService
     * @throws \Exception
     */
    public function get(): StorageService
    {
        return StorageService::getInstance();
    }
}

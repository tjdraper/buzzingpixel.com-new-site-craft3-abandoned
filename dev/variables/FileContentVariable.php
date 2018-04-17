<?php

namespace dev\variables;

use dev\Module;
use dev\services\FileContentService;

/**
 * Class FileContentVariable
 */
class FileContentVariable
{
    /**
     * Gets the file content service
     * @return FileContentService
     * @throws \Exception
     */
    public function get(): FileContentService
    {
        return Module::fileContentService();
    }
}

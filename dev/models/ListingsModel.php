<?php

namespace dev\models;

use felicity\datamodel\Model;
use felicity\datamodel\services\datahandlers\ArrayHandler;

/**
 * Class ListingsModel
 */
class ListingsModel extends Model
{
    /** @var array $listings */
    public $listings;

    /** @var array $meta */
    public $meta;

    /**
     * @inheritdoc
     */
    protected function defineHandlers(): array
    {
        return [
            'listings' => ArrayHandler::class,
            'meta' => ArrayHandler::class,
        ];
    }
}

<?php

namespace dev\models;

use felicity\datamodel\Model;
use dev\models\ListingMetaModel;
use felicity\datamodel\services\datahandlers\ArrayHandler;

/**
 * Class ListingsModel
 */
class ListingsModel extends Model
{
    /** @var ListingMetaModel[] $listings */
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

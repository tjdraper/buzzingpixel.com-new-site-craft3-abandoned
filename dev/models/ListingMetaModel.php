<?php

namespace dev\models;

use felicity\datamodel\Model;
use dev\models\FileContentModel;
use felicity\datamodel\services\datahandlers\ArrayHandler;
use felicity\datamodel\services\datahandlers\StringHandler;
use felicity\datamodel\services\datahandlers\DateTimeHandler;

/**
 * Class FileContentModel
 */
class ListingMetaModel extends Model
{
    /** @var string $fullDirectoryPath */
    public $fullDirectoryPath;

    /** @var string $markdown */
    public $markdown;

    /** @var array $meta */
    public $meta;

    /** @var string $html */
    public $html;

    /** @var string $title */
    public $title;

    /** @var string $slug */
    public $slug;

    /** @var string $dateString */
    public $dateString;

    /** @var \DateTime $date */
    public $date;

    /** @var FileContentModel $contentModel */
    public $contentModel;

    /**
     * @inheritdoc
     */
    protected function defineHandlers(): array
    {
        return [
            'fullDirectoryPath' => StringHandler::class,
            'markdown' => StringHandler::class,
            'meta' => ArrayHandler::class,
            'html' => StringHandler::class,
            'title' => StringHandler::class,
            'slug' => StringHandler::class,
            'dateString' => StringHandler::class,
            'date' => DateTimeHandler::class,
        ];
    }
}

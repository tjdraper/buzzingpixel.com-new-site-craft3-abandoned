<?php

namespace modules\store\factories;

use craft\db\Query;

/**
 * Class QueryFactory
 */
class QueryFactory
{
    /**
     * Gets a new query class
     * @return Query
     */
    public function getQuery(): Query
    {
        return new Query();
    }
}

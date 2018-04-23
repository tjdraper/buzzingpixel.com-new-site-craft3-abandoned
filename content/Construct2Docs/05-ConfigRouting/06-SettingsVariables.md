{
    "title": "Settings Variables"
}

There are a number of items you can set within a route key. These items will override the Node for this route if there is one. It will also hide those items to users in the Control Panel.

### `template => 'site/_my-template'`

Set the template being served.

### `'entryId' => 231`

Set the entry ID variable.

### `'pagination' => 6`

Set the number of pagination items.

### `'listingChannels' => 'blog|news'`

Set the listing channels.

### `'listingEntryTemplate' => true`

This only takes a boolean to hide the Control Panel item when editing the Node for this route. You would still need to do your own route matching for the entry and set the template there.

### `'listingCategoryTemplate' => true`

The same applies to this item.

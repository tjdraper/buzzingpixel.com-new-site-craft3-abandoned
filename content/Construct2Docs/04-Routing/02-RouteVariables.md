{
    "title": "Route Variables"
}

Construct makes certain variables available when it matches a route or a Node.

<div class="Note">
    <div class="Note__Title">
        Note
    </div>
    <div class="Note__Body">
        <p>If the route is being served by the config file but does not match a node, and the values are not set by the config (where applicable), the values of these items will be set to false.</p>
    </div>
</div>

### `{construct_route:node_id}`

The ID of the currently matched Node.

### `{construct_route:node_tree_id}`

The ID of the Tree from the currently matched Node.

### `{construct_route:node_parent_id}`

The parent ID of the currently matched Node. 0 if Node has no parent.

### `{construct_route:node_level}`

The level of the currently matched Node.

### `{construct_route:node_name}`

The name of the currently matched Node.

### `{construct_route:node_slug}`

The slug of the currently matched node — which will be the same as the last URI segment.

### `{construct_route:node_external_link}`

The external link field of the currently matched Node.

### `{construct_route:node_full_route}`

The full route of the currently matched Node. Example: `about/executives/ceo`.

### `{construct_route:node_entry_id}`

The entry ID of the selected entry for the currently matched Node. When using Construct to create pages, this is how you connect everything together. You can feed this tag into the `entry_id` parameter of an `exp:channel:entries` tag pair to serve the specified Node entry.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:channel:entries
    disable="categories|member_data|pagination"
    dynamic="no"
    entry_id="{construct_route:node_entry_id}"
    limit="1"
    status="open"
}
    <h1>{title}</h1>
    {body}
{/exp:channel:entries}
```

### `{construct_route:node_output}`

Whether the currently matched Node is set to output in Menus.

### `{construct_route:node_pagination}`

Whether the currently matched Node is set to paginate.

### `{construct_route:node_pagination_amount}`

The pagination amount set for the currently matched Node.

### `{construct_route:node_listing_channels}`

The channel(s) chosen for listing. If there is more than on channel, they will be pipe delimited.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:channel:entries
    disable="categories|member_data"
    dynamic="no"
    channel="{construct_route:node_listing_channels}"
    {if construct_route:node_pagination}
    limit="{construct_route:node_pagination_amount}"
    {if:else}
    limit="1"
    {/if}
    status="open"
}
    <h1>{title}</h1>
    {body}
{/exp:channel:entries}
```

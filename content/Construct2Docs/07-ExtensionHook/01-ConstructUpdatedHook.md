{
    "title": "construct_updated Hook"
}

Construct fires the `construct_updated` hook any time a node is added, updated, or deleted. If you need to run actions in your extension when one of these actions happens, register your extension hook for `construct_updated`.

This hook provides one argument, an array of affected nodes.

<div class="CodeBlockTitle">Example</div>
```php
array(
    0 => array(
        'node_id' => 4,
        'node_tree_id' => 2,
        'node_order' => 2,
        'node_parent' => 2,
        'node_level' => 3,
        'node_name' => 'The Matrix Has You!'
        'node_slug' => 'the-matrix',
        'node_full_route' => 'about/neo/the-matrix',
        'node_routing' => 1,
        'node_template_id' => 29,
        'node_entry_id' => 86,
        'node_output' => 1
    )
)
```

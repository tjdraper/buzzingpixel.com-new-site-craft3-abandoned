{
    "title": "Entry IDs Single Tag"
}

The `{exp:construct:entry_ids}` single tag has one purpose: to retrieve nodes and output the Channel Entry IDs associated with those nodes as a pipe-delimited string. As such, it will not retrieve any nodes that do not have an assigned entry. All available parameters work identically to their counterparts in the Nodes tag pair.

<div class="CodeBlockTitle">Output</div>
```ee
23|56|456|543
```

<div class="CodeBlockTitle">Breadcrumbs Tag Pair Parameters</div>
```ee
tree_id="1"
max_depth="2" {!-- Limit the depth of nesting the tag will output --}
parent_id="{construct_route:node_id}" {!-- Get child nodes of parent --}
direct_parent="{construct_route:node_id}"
node_slug="{segment_2}"
node_full_route="{segment_1}/{segment_2}"
menu_output_only="false"
```

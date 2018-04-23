{
    "title": "Breadcrumbs Tag Pair"
}

The `{exp:construct:breadcrumbs}` tag pair is used to output a Node's hierarchy.

<div class="CodeBlockTitle">Example</div>
```ee
{exp:construct:breadcrumbs}
    {construct:node_name}
    {construct:node_slug}
    {construct:node_link}
{/exp:construct:breadcrumbs}
```

<div class="CodeBlockTitle">Breadcrumbs Tag Pair Parameters</div>
```ee
tree_id="1"
namespace="my_namespace" {!-- default namespace is "construct" --}
node_entry_id="103" {!-- Only nodes with specified entry id --}
node_id="45" {!-- Hard code node_id instead of starting from detected page --}
node_full_route="{segment_1}/{segment_2}" {!-- Same as ID excepting using route --}
```

### Breadcrumbs Tag Pair Variables

The Breadcrumbs Tag Pair supports most of the tag variables that the `{exp:construct:nodes}` tag does with a few extras and exceptions.

#### Additional variable tags:

- `{construct:breadcrumb_index}`
- `{construct:breadcrumb_count}`
- `{construct:breadcrumb_total_results}`

#### Unsupported variable tags:

- `{construct:level_index}`
- `{construct:level_count}`
- `{construct:level_total_results}`
- `{construct:has_children}`
- `{construct:children}`
